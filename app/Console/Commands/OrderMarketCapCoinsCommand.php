<?php

namespace App\Console\Commands;

use App\Models\Coin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class OrderMarketCapCoinsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order-coins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $coins = Coin::whereNotNull('market_cap_rank')
            ->select('key')
            ->orderBy('market_cap_rank')
            ->take(100)
            ->get();

        $data = Http::withoutVerifying()->get("https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=" . $coins->implode("key",','))->json();

        foreach ($data as $coin) {
            Coin::where('key', $coin['id'])->update([
                'market_cap_rank' => $coin['market_cap_rank']
            ]);
        }
    }
}

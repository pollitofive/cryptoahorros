<?php

namespace App\Console\Commands;

use App\Models\Coin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SaveCoinsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save-coins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        if(Coin::all()->count() == 0) {
            $coins = Http::withoutVerifying()->get("https://api.coingecko.com/api/v3/coins/list")->json();
            foreach($coins as $coin) {
                Coin::create([
                    'key' => $coin['id'],
                    'symbol' => $coin['symbol'],
                    'name' => $coin['name']
                ]);
            }
        }


        do {
            $coins = Coin::whereNull('market_cap_rank')->select('coin_key')->limit(100)->get();

            $coins = $coins->implode('key',',');
            $data = Http::withoutVerifying()->get("https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=$coins")->json();
            Log::info('Running');
            if(isset($data["status"]["error_code"])) {
                sleep(80);
                $data = Http::withoutVerifying()->get("https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=$coins")->json();
            }
            foreach($data as $coin) {
                Coin::where('coin_key', $coin['id'])->update([
                    'image' => $coin['image'],
                    'market_cap_rank' => $coin['market_cap_rank']
                ]);
            }
        }
        while($coins != null);
    }
}

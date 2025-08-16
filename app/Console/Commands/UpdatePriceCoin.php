<?php

namespace App\Console\Commands;

use App\Models\Coin;
use App\Models\Market;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class UpdatePriceCoin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:price-coin';

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
        $coins = Coin::orderBy('market_cap_rank')->take(1000)->get();
        $first_500 = $coins->take(500);
        $second_500 = $coins->take(-500);

        $this->find($first_500);
        $this->find($second_500);
    }

    private function find(Collection $coins): void
    {
        $string_coins = $coins->pluck('coin_key')->implode(',');
        $url = "https://api.coingecko.com/api/v3/simple/price?ids=$string_coins&vs_currencies=usd";
        $response = Http::withoutVerifying()->get($url);
        foreach($coins as $coin) {
            if(isset($response->json()[$coin->coin_key]['usd'])) {
                $coin_x_price = new Market();
                $coin_x_price->coin_id = $coin->id;
                $coin_x_price->current_price = $response->json()[$coin->coin_key]['usd'];
                $coin_x_price->save();
            }
        }
    }
}

<?php

namespace App\Connectors\API;

use App\Connectors\Contracts\CoinPriceInterface;
use App\Models\Market;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CoingeckoCoinPriceService implements CoinPriceInterface
{
    private string $url = 'https://api.coingecko.com/';

    public function getUrl(string $ids): string
    {
        return $this->url . "api/v3/simple/price?ids=$ids&vs_currencies=usd";
    }

    public function execute(Collection $coins): void
    {
        $ids = $coins->pluck('coin_key')->implode(',');
        $response = Http::withoutVerifying()->get($this->getUrl($ids));
        foreach($coins as $coin) {
            if(isset($response->json()[$coin->coin_key]['usd'])) {
                Market::create($coin->id, $response->json()[$coin->coin_key]['usd']);
            }
        }
    }
}

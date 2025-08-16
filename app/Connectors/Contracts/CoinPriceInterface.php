<?php

namespace App\Connectors\Contracts;

use Illuminate\Support\Collection;

interface CoinPriceInterface
{
    public function getUrl(string $ids): string;
    public function execute(Collection $coins): void;
}

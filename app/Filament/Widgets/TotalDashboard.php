<?php

namespace App\Filament\Widgets;

use App\Models\Coin;
use App\Models\Currency;
use App\Models\Quote;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalDashboard extends BaseWidget
{
    protected function getColumns(): int
    {
        return 2;
    }
    protected function getStats(): array
    {
        $price_buy = Quote::getCurrentPriceByDollar(2)->price_buy;
        $total_in_dollars = (float) Coin::getSumAmountByPriceOfCoin() + (float) Currency::getSumInDollars();
        $total_in_ars = $total_in_dollars * $price_buy;

        return [
            Stat::make('Total sum in USD', "USD " . number_format($total_in_dollars,2)),
            Stat::make('Total sum currencies in $', "ARS " . number_format($total_in_ars,2)),
        ];
    }
}

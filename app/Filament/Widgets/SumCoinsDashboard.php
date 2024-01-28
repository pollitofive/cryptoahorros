<?php

namespace App\Filament\Widgets;

use App\Models\Coin;
use App\Models\Quote;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SumCoinsDashboard extends BaseWidget
{

    protected function getColumns(): int
    {
        return 2;
    }


    protected function getStats(): array
    {
        $price_buy = Quote::getCurrentPriceByDollar(2)->price_buy;
        $total_coins_in_dollars = Coin::getSumAmountByPriceOfCoin();
        $total_coins_in_ars = $total_coins_in_dollars * $price_buy;
        return [
            Stat::make('Total sum coins in USD', "USD " . number_format($total_coins_in_dollars,2))->extraAttributes(['class' => 'bg-neutral-50']),
            Stat::make('Total sum coins in $', "ARS " . number_format($total_coins_in_ars,2))
        ];
    }
}

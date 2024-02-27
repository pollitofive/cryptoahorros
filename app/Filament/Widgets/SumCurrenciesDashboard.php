<?php

namespace App\Filament\Widgets;

use App\Models\Coin;
use App\Models\Currency;
use App\Models\Quote;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SumCurrenciesDashboard extends BaseWidget
{
    protected function getColumns(): int
    {
        return 2;
    }
    protected function getStats(): array
    {
        $total_currencies_in_dollars = Currency::getSumInDollars();
        $total_currencies_in_ars = $total_currencies_in_dollars * auth()->user()->price_dollar_selected;
        return [
            Stat::make('Total sum currencies in USD', "USD " . number_format($total_currencies_in_dollars,2)),
            Stat::make('Total sum currencies in $', "ARS " . number_format($total_currencies_in_ars,2)),
        ];
    }
}

<?php

namespace App\Filament\Resources\AccountXCurrencyResource\Widgets;

use App\Models\Quote;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DollarPriceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $dollar_official = Quote::getCurrentPriceByDollar(1);
        $dollar_blue = Quote::getCurrentPriceByDollar(2);
        $dollar_exchange = Quote::getCurrentPriceByDollar(3);
        return [
            Stat::make('Dolar Blue Venta', "USD 1 = $".$dollar_blue->price_sell)
                ->description('Updated at ' . $dollar_blue->created_at->format("d/m/Y H:i:s"))
                ->color('success'),
            Stat::make('Dolar Bolsa Venta', "USD 1 = $".$dollar_exchange->price_sell)
                ->description('Updated at ' . $dollar_exchange->created_at->format("d/m/Y H:i:s"))
                ->color('warning'),
            Stat::make('Dolar Oficial Venta (Sin impuestos)', "USD 1 = $".$dollar_official->price_sell)
                ->description('Updated at ' . $dollar_official->created_at->format("d/m/Y H:i:s"))
                ->color('info'),
            Stat::make('Dolar Blue Compra', "USD 1 = $".$dollar_blue->price_buy)
                ->description('Updated at ' . $dollar_blue->created_at->format("d/m/Y H:i:s"))
                ->color('success'),
            Stat::make('Dolar Bolsa Compra', "USD 1 = $".$dollar_exchange->price_buy)
                ->description('Updated at ' . $dollar_exchange->created_at->format("d/m/Y H:i:s"))
                ->color('warning'),
            Stat::make('Dolar Oficial Compra (Sin impuestos)', "USD 1 = $".$dollar_official->price_buy)
                ->description('Updated at ' . $dollar_official->created_at->format("d/m/Y H:i:s"))
                ->color('info'),
        ];
    }
}

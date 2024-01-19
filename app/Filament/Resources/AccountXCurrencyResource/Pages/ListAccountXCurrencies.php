<?php

namespace App\Filament\Resources\AccountXCurrencyResource\Pages;

use App\Filament\Resources\AccountXCurrencyResource;
use App\Filament\Resources\AccountXCurrencyResource\Widgets\DollarPriceOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountXCurrencies extends ListRecords
{
    protected static string $resource = AccountXCurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Currency'),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            DollarPriceOverview::class
        ];
    }
}

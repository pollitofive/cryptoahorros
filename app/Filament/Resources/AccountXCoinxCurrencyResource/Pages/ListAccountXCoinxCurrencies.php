<?php

namespace App\Filament\Resources\AccountXCoinxCurrencyResource\Pages;

use App\Filament\Resources\AccountXCoinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountXCoinxCurrencies extends ListRecords
{
    protected static string $resource = AccountXCoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\AccountXCoinxCurrencyResource\Pages;

use App\Filament\Resources\AccountXCoinxCurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountXCoinxCurrency extends EditRecord
{
    protected static string $resource = AccountXCoinxCurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

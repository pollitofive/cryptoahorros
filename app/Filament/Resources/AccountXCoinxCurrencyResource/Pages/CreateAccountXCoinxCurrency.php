<?php

namespace App\Filament\Resources\AccountXCoinxCurrencyResource\Pages;

use App\Filament\Resources\AccountXCoinResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountXCoinxCurrency extends CreateRecord
{
    protected static string $resource = AccountXCoinResource::class;
    protected static ?string $title = "New Coin";

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

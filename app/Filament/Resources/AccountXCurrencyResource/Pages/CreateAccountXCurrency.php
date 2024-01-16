<?php

namespace App\Filament\Resources\AccountXCurrencyResource\Pages;

use App\Filament\Resources\AccountXCurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountXCurrency extends CreateRecord
{
    protected static string $resource = AccountXCurrencyResource::class;
    protected static ?string $title = "New Currency";

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

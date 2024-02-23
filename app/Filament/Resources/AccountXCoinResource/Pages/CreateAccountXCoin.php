<?php

namespace App\Filament\Resources\AccountXCoinResource\Pages;

use App\Filament\Resources\AccountXCoinResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountXCoin extends CreateRecord
{
    protected static string $resource = AccountXCoinResource::class;
    protected static ?string $title = "New Coin";

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

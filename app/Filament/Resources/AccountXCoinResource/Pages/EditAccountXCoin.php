<?php

namespace App\Filament\Resources\AccountXCoinResource\Pages;

use App\Filament\Resources\AccountXCoinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountXCoin extends EditRecord
{
    protected static string $resource = AccountXCoinResource::class;
    protected static ?string $title = "Edit Coin";


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace App\Filament\Resources\AccountXCoinResource\Pages;

use App\Filament\Resources\AccountXCoinResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateAccountXCoin extends CreateRecord
{
    protected static string $resource = AccountXCoinResource::class;
    protected static ?string $title = "New Coin";


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['amount'] = Str::replace(",", ".", $data['amount']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

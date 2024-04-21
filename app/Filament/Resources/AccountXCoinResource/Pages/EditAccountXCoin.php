<?php

namespace App\Filament\Resources\AccountXCoinResource\Pages;

use App\Filament\Resources\AccountXCoinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditAccountXCoin extends EditRecord
{
    protected static string $resource = AccountXCoinResource::class;
    protected static ?string $title = "Edit Coin";

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['amount'] = Str::replace(",", ".", $data['amount']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

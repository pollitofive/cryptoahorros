<?php

namespace App\Filament\Resources\AccountXCurrencyResource\Pages;

use App\Filament\Resources\AccountXCurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountXCurrency extends EditRecord
{
    protected static string $resource = AccountXCurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\AccountXCoinResource\Pages;

use App\Filament\Resources\AccountXCoinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountXCoin extends ListRecords
{
    protected static string $resource = AccountXCoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Coin'),
        ];
    }
}

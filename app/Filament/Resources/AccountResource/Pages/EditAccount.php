<?php

namespace App\Filament\Resources\CountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;
    protected static ?string $title = "Edit Account";


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

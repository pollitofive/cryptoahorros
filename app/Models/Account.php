<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Account extends Model
{
    protected $guarded = [];

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('url')
                ->maxLength(255),
            ];
    }

    public function accountxcoinsxcurrencies(): HasMany
    {
        return $this->hasMany(AccountXCoinxCurrency::class);
    }


}

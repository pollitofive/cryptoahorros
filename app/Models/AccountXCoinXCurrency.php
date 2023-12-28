<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AccountXCoinXCurrency extends Model
{
    protected $table = 'accounts_x_coins_x_currencies';

    protected $guarded = [];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function coin(): BelongsTo
    {
        return $this->BelongsTo(Coin::class)->whereNotNull('coins.market_cap_rank')->orderBy('coins.market_cap_rank');
    }

    public function currency(): BelongsTo
    {
        return $this->BelongsTo(Currency::class);
    }
}

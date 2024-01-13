<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Coin extends Model
{
    use HasFactory;

    protected $fillable = ['coin_key','symbol','name','image','market_cap_rank'];

    public function markets(): HasMany
    {
        return $this->hasMany(Market::class)->orderBy('created_at','desc');
    }

    public function getCurrentPriceAttribute(): string
    {
        return $this->markets->first()->current_price;
    }

    public static function getSumAmountByPriceOfCoin(): string
    {
        $accounts_by_coins = AccountXCoin::get();
        $total = 0;
        foreach($accounts_by_coins as $account_by_coin) {
            $total += $account_by_coin->amount * $account_by_coin->coin->current_price;
        }

        return $total;
    }


}

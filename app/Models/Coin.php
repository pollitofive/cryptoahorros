<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Http;

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
        if($this->markets->first() === null) {
            $url = "https://api.coingecko.com/api/v3/simple/price?ids=$this->coin_key&vs_currencies=usd";
            $response = Http::withoutVerifying()->get($url);

            if(! empty ($response->json()['status'])) {
                return 0;
            }

            if(! empty($response->json()[$this->coin_key]['usd'])) {
                $coin_x_price = new Market();
                $coin_x_price->coin_id = $this->id;
                $coin_x_price->current_price = $response->json()[$this->coin_key]['usd'];
                $coin_x_price->save();
                return $coin_x_price->current_price;
            }
            return 0;
        }

        return $this->markets->first()->current_price;
    }

    public static function getSumAmountByPriceOfCoin(): string
    {
        $accounts_by_coins = AccountXCoin::join('accounts','accounts_x_coins.account_id','accounts.id')
            ->where('user_id',auth()->id())
            ->get();

        $total = 0;
        foreach($accounts_by_coins as $account_by_coin) {
            $total += $account_by_coin->amount * $account_by_coin->coin->current_price;
        }

        return $total;
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'symbol',
    ];

    public static function getSumInDollars(): string
    {
        $accounts_by_currency = AccountXCurrency::join('accounts','accounts_x_currencies.account_id','accounts.id')
            ->where('user_id',auth()->id())
            ->get();
        $total = 0;

        foreach($accounts_by_currency as $account_by_currency) {

            if($account_by_currency->currency->symbol == 'USD') {
                $total += $account_by_currency->amount;
            } else {
                $total += $account_by_currency->amount / auth()->user()->price_dollar_selected;
            }

        }

        return $total;

    }

}

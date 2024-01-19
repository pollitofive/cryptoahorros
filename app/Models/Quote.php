<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'dollar_id','price_buy','price_sell'
    ];

    public static function getCurrentPriceByDollar($dollar_id): self
    {
        return self::select('price_buy','price_sell','created_at')->where('dollar_id', $dollar_id)->orderBy('created_at','desc')->first();
    }
}

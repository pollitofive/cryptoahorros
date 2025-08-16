<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    public static function create(int $coin_id, float $current_price): self
    {
        $market = new Market();
        $market->coin_id = $coin_id;
        $market->current_price = $current_price;
        $market->save();

        return $market;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dollar extends Model
{
    use HasFactory;
    protected $fillable = [
        'description','key','category'
    ];

    public function current_price(): Quote
    {
        return Quote::getCurrentPriceByDollar($this->id);
    }
}

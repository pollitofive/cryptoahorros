<?php

namespace Database\Factories;

use App\Models\Coin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class MarketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coin_id' => Coin::factory()->create(),
            'current_price' => $this->faker->numberBetween(1,10000),
        ];
    }
}

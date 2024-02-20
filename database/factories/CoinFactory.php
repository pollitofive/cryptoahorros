<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coin>
 */
class CoinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coin_key' => $this->faker->uuid(),
            'symbol' => $this->faker->lastName,
            'name' => $this->faker->name,
            'market_cap_rank' => $this->faker->numberBetween(1,10000),
        ];
    }
}

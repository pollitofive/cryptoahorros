<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Coin;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountXCoinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory()->create(),
            'coin_id' => Coin::factory()->create(),
            'amount' => $this->faker->numberBetween(1,1000)
        ];
    }
}

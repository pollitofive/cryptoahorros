<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Damián',
            'email' => 'damianladiani@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $this->call(DollarsSeeder::class);
        $this->call(CurrencySeeder::class);
    }
}

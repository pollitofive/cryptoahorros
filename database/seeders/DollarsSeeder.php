<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DollarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dollars')->insert([
            'description' => 'Dolar oficial',
            'key' => 'casa349'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar blue',
            'key' => 'casa310'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar contado con liqui',
            'key' => 'casa312'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar bolsa',
            'key' => 'casa313'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar turista',
            'key' => 'casa406'
        ]);
    }
}

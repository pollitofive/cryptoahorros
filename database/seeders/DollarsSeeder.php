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
            'category' => 'valores_principales',
            'key' => 'casa349'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar blue',
            'category' => 'Blue',
            'key' => 'casa380'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar contado con liqui',
            'category' => 'valores_principales',
            'key' => 'casa312'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar bolsa',
            'category' => 'valores_principales',
            'key' => 'casa313'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar turista',
            'category' => 'valores_principales',
            'key' => 'casa406'
        ]);
    }
}

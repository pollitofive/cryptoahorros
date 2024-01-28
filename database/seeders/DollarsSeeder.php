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
            'category' => 'Capital_Federal',
            'key' => 'casa6'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar blue',
            'category' => 'Dolar',
            'key' => 'casa380'
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

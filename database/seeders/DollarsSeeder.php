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
            'url' => 'https://dolarhoy.com/cotizaciondolaroficial',
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar blue',
            'url' => 'https://dolarhoy.com/cotizaciondolarblue',
        ]);

        DB::table('dollars')->insert([
            'description' => 'Dolar bolsa',
            'url' => 'https://dolarhoy.com/cotizaciondolarbolsa'
        ]);
        DB::table('dollars')->insert([
            'description' => 'Dolar turista',
            'url' => 'https://dolarhoy.com/cotizacion-dolar-tarjeta',
        ]);
    }
}

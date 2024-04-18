<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Agrega esta línea para importar la clase DB

class Ajustes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ajustes')->insert([
            'sm_med' => 3,
            'med_big' => 5,
            'Enfermedad1' => 5,
            'Enfermedad2' => 10,
            'Enfermedad3' => 15,
            'Bajon' => 2,
        ]);
    }
}

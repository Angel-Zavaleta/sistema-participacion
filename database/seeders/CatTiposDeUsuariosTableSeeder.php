<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTiposDeUsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inserta los registros en la tabla cat_tipos_de_usuarios
        DB::table('cat_tipos_de_usuarios')->insert([
            ['id' => 1, 'tipo' => 'Administrador'],
            ['id' => 2, 'tipo' => 'Supervisor'],
            ['id' => 3, 'tipo' => 'Ciudadano'],
            ['id' => 4, 'tipo' => 'Colectivo'],
        ]);
    }
}

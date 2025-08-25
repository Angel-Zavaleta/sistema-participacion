<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSexoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inserta los registros en la tabla cat_sexo
        DB::table('cat_sexo')->insert([
            ['id' => 1, 'sexo' => 'Masculino'],
            ['id' => 2, 'sexo' => 'Femenino'],
            ['id' => 3, 'sexo' => 'Otro'],
        ]);
    }
}

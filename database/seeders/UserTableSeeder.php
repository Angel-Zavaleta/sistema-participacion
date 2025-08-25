<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'nombre' => 'Angel Josue',
                'apellido_paterno' => 'Zavaleta',
                'apellido_materno' => 'Utrera',
                'cat_sexo_id' => '1',
                'email' => 'angel.zavaleta@campeche.gob.mx',
                'password' => Hash::make('12345678'),
                'cat_localidad_id' => '323',
                'cat_tipo_usuario_id' => '1',
            ],
            [
                'id' => 2,
                'nombre' => 'Supervisor',
                'apellido_paterno' => 'Test',
                'apellido_materno' => 'Test',
                'cat_sexo_id' => '2',
                'email' => 'angel21zavaleta@gmail.com',
                'password' => Hash::make('12345678'),
                'cat_localidad_id' => '1',
                'cat_tipo_usuario_id' => '2',
            ],
            [
                'id' => 3,
                'nombre' => 'Ciudadano',
                'apellido_paterno' => 'Test',
                'apellido_materno' => 'Test',
                'cat_sexo_id' => '3',
                'email' => 'zava05utrera@gmail.com',
                'password' => Hash::make('12345678'),
                'cat_localidad_id' => '2',
                'cat_tipo_usuario_id' => '3',
            ],
        ]);
    }
}

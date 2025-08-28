<?php

use App\Models\User;
use App\Models\CatTemasDeInteres;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear datos mínimos para foreign keys
    DB::table('cat_localidades')->insert([
        'id_localidad' => 1,
        'entidad' => '01',
        'nombre_entidad' => 'Test Entidad',
        'municipio' => '001',
        'nombre_municipio' => 'Test Municipio',
        'nombre_localidad' => 'Test Localidad',
        'activo' => 1,
    ]);
    
    DB::table('cat_tipos_de_usuarios')->insert([
        'id' => 1,
        'tipo' => 'Test Tipo',
        'activo' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    $this->usuario = User::factory()->create();
    Sanctum::actingAs($this->usuario, ['*']);
});

describe('API - Crear tema de interés', function () {
    
    it('puede crear un tema vía API', function () {
        $datos = [
            'tema' => 'Nuevo Tema de Prueba',
            'user_id' => $this->usuario->id,
        ];

        $response = $this->postJson('/api/admin/temas/de/interes', $datos);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'exito',
                'mensaje',
                'datos' => [
                    'tema' => [
                        'id', 
                        'tema', 
                        'user_id', 
                        'created_at', 
                        'updated_at',
                        'user_creador_del_tema' => ['id', 'nombre']
                    ]
                ]
            ])
            ->assertJson([
                'exito' => true,
                'mensaje' => 'Tema de Interes creado exitosamente',
                'datos' => [
                    'tema' => [
                        'tema' => 'Nuevo Tema de Prueba',
                        'user_id' => $this->usuario->id
                    ]
                ]
            ]);

        $this->assertDatabaseHas('cat_temas_de_interes', [
            'tema' => 'Nuevo Tema de Prueba',
            'user_id' => $this->usuario->id,
            'activo' => 1,
        ]);
    });

    it('valida campos requeridos al crear', function () {
        $response = $this->postJson('/api/admin/temas/de/interes', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['tema', 'user_id']);
    });

    it('valida longitud mínima del tema', function () {
        $datos = [
            'tema' => 'ABC', // Muy corto (menos de 5 caracteres)
            'user_id' => $this->usuario->id,
        ];

        $response = $this->postJson('/api/admin/temas/de/interes', $datos);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['tema']);
    });

    it('valida que user_id exista', function () {
        $datos = [
            'tema' => 'Tema Válido',
            'user_id' => 99999, // ID que no existe
        ];

        $response = $this->postJson('/api/admin/temas/de/interes', $datos);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_id']);
    });

    it('retorna error cuando tema ya existe', function () {
        // Crear tema existente
        CatTemasDeInteres::create([
            'tema' => 'Tema Duplicado',
            'user_id' => $this->usuario->id,
            'activo' => 1,
        ]);

        $datos = [
            'tema' => 'Tema Duplicado',
            'user_id' => $this->usuario->id,
        ];

        $response = $this->postJson('/api/admin/temas/de/interes', $datos);

        $response->assertStatus(400)
            ->assertJson([
                'exito' => false,
                'mensaje' => 'Error al crear el tema de interés',
            ])
            ->assertJsonFragment([
                'error' => 'Ya existe un tema de interés con el mismo nombre'
            ]);
    });
});

describe('API - Actualizar tema de interés', function () {
    
    it('puede actualizar un tema vía API', function () {
        $tema = CatTemasDeInteres::create([
            'tema' => 'Tema Original',
            'user_id' => $this->usuario->id,
            'activo' => 1,
        ]);

        $datos = ['tema' => 'Tema Actualizado'];

        $response = $this->putJson("/api/admin/temas/de/interes/{$tema->id}", $datos);

        $response->assertStatus(200)
            ->assertJson([
                'exito' => true,
                'mensaje' => 'Tema de Interes actualizado exitosamente',
            ])
            ->assertJsonPath('datos.tema.tema', 'Tema Actualizado');

        $this->assertDatabaseHas('cat_temas_de_interes', [
            'id' => $tema->id,
            'tema' => 'Tema Actualizado',
        ]);
    });

    it('retorna error cuando tema a actualizar no existe', function () {
        $datos = ['tema' => 'Tema Actualizado'];

        $response = $this->putJson('/api/admin/temas/de/interes/999', $datos);

        $response->assertStatus(400)
            ->assertJson([
                'exito' => false,
                'mensaje' => 'Error al actualizar el tema de interés',
            ]);
    });

    it('valida campos requeridos al actualizar', function () {
        $tema = CatTemasDeInteres::create([
            'tema' => 'Tema Test',
            'user_id' => $this->usuario->id,
            'activo' => 1,
        ]);

        $response = $this->putJson("/api/admin/temas/de/interes/{$tema->id}", []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['tema']);
    });
});

describe('API - Eliminar tema de interés', function () {
    
    it('puede eliminar un tema vía API', function () {
        $tema = CatTemasDeInteres::create([
            'tema' => 'Tema a Eliminar',
            'user_id' => $this->usuario->id,
            'activo' => 1,
        ]);

        $response = $this->deleteJson("/api/admin/temas/de/interes/{$tema->id}");

        $response->assertStatus(200)
            ->assertJson([
                'exito' => true,
                'mensaje' => 'Tema de Interes eliminado exitosamente',
            ]);

        $this->assertDatabaseHas('cat_temas_de_interes', [
            'id' => $tema->id,
            'activo' => false,
        ]);
    });

    it('retorna error al eliminar tema inexistente', function () {
        $response = $this->deleteJson('/api/admin/temas/de/interes/999');

        $response->assertStatus(400)
            ->assertJson([
                'exito' => false,
                'mensaje' => 'Error al eliminar el tema de interés',
            ]);
    });

    it('retorna error al eliminar tema ya inactivo', function () {
        $tema = CatTemasDeInteres::create([
            'tema' => 'Tema Inactivo',
            'user_id' => $this->usuario->id,
            'activo' => 0,
        ]);

        $response = $this->deleteJson("/api/admin/temas/de/interes/{$tema->id}");

        $response->assertStatus(400)
            ->assertJsonStructure([
                'exito',
                'mensaje',
                'error'
            ]);
    });
});

describe('API - Listar temas de interés', function () {
    
    it('puede listar temas activos vía API', function () {
        // Crear temas de prueba
        collect(range(1,3))->each(fn($i) => CatTemasDeInteres::create([
            'tema' => "Tema Activo $i",
            'user_id' => $this->usuario->id,
            'activo' => 1
        ]));
        collect(range(1,2))->each(fn($i) => CatTemasDeInteres::create([
            'tema' => "Tema Inactivo $i",
            'user_id' => $this->usuario->id,
            'activo' => 0
        ]));

        $response = $this->getJson('/api/admin/temas/de/interes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'exito',
                'mensaje',
                'datos' => [
                    'temas' => [
                        '*' => ['id', 'tema', 'user_id', 'activo', 'created_at', 'updated_at']
                    ],
                    'total'
                ]
            ])
            ->assertJson([
                'exito' => true,
                'mensaje' => 'Temas de interés obtenidos exitosamente',
            ])
            ->assertJsonPath('datos.total', 3);

        // Verificar que todos los temas retornados están activos
        $temas = $response->json('datos.temas');
        foreach ($temas as $tema) {
            expect($tema['activo'])->toBeTrue();
        }
    });

    it('retorna lista vacía cuando no hay temas activos', function () {
        // Solo crear temas inactivos
        collect(range(1,2))->each(fn($i) => CatTemasDeInteres::create([
            'tema' => "Tema Inactivo $i",
            'user_id' => $this->usuario->id,
            'activo' => 0
        ]));

        $response = $this->getJson('/api/admin/temas/de/interes');

        $response->assertStatus(200)
            ->assertJsonPath('datos.total', 0)
            ->assertJsonPath('datos.temas', []);
    });
});

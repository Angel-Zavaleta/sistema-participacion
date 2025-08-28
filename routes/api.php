<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Administrador\TemasDeInteres\TemasDeInteresController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas API para tu aplicación. Estas
| rutas son cargadas por el RouteServiceProvider y todas serán asignadas
| al grupo de middleware "api". ¡Haz algo genial!
|
*/

// Rutas públicas (sin autenticación)
Route::prefix('publico')->group(function () {
    // Rutas que no requieren autenticación
    // Ejemplo: Route::get('estadisticas', [EstadisticaController::class, 'publicas']);
});


// Rutas de administración (requieren autenticación y verificacion)
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::prefix('temas/de/interes')->group(function () {
        Route::get('/', [TemasDeInteresController::class, 'listarTemasActivos']);
        Route::post('/', [TemasDeInteresController::class, 'crearNuevoTemaDeInteres']);
        Route::put('/{id}', [TemasDeInteresController::class, 'actualizarTemaDeInteres']);
        Route::delete('/{id}', [TemasDeInteresController::class, 'eliminarTemaDeInteres']);
    });
});
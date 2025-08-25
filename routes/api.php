<?php

use Illuminate\Support\Facades\Route;

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

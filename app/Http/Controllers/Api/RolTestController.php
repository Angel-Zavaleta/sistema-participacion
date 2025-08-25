<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolTestController extends Controller
{
    /**
     * Endpoint para probar acceso solo de Administrador
     */
    public function soloAdministrador(Request $request)
    {
        $tipoUsuario = \App\Models\CatTipoDeUsuario::find(Auth::user()->cat_tipo_usuario_id);

        return response()->json([
            'mensaje' => '¡Acceso exitoso! Solo administradores pueden ver esto.',
            'usuario' => Auth::user()->name,
            'rol' => $tipoUsuario?->tipo,
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Endpoint para probar acceso de Administrador y Supervisor
     */
    public function adminYSupervisor(Request $request)
    {
        $tipoUsuario = \App\Models\CatTipoDeUsuario::find(Auth::user()->cat_tipo_usuario_id);

        return response()->json([
            'mensaje' => '¡Acceso exitoso! Administradores y Supervisores pueden ver esto.',
            'usuario' => Auth::user()->nombre,
            'rol' => $tipoUsuario?->tipo,
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Endpoint para probar acceso de Ciudadano y Colectivo
     */
    public function ciudadanoYColectivo(Request $request)
    {
        $tipoUsuario = \App\Models\CatTipoDeUsuario::find(Auth::user()->cat_tipo_usuario_id);

        return response()->json([
            'mensaje' => '¡Acceso exitoso! Ciudadanos y Colectivos pueden ver esto.',
            'usuario' => Auth::user()->nombre,
            'rol' => $tipoUsuario?->tipo,
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Endpoint para mostrar información del usuario actual
     */
    public function miInfo(Request $request)
    {
        $usuario = Auth::user();
        $tipoUsuario = \App\Models\CatTipoDeUsuario::find($usuario->cat_tipo_usuario_id);

        return response()->json([
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'email' => $usuario->email,
            'rol' => $tipoUsuario?->tipo ?? 'Sin rol',
        ]);
    }
}

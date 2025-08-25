<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarRolSimple
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$rolesPermitidos): Response
    {
        // Verificar si el usuario está autenticado
        if (! Auth::check()) {
            return response()->json([
                'mensaje' => 'No autorizado. Debe iniciar sesión.',
                'error' => 'no_autenticado',
            ], 401);
        }

        $usuario = Auth::user();

        // Obtener el tipo de usuario desde la base de datos
        $tipoUsuario = \App\Models\CatTipoDeUsuario::find($usuario->cat_tipo_usuario_id);

        // Si no tiene tipo de usuario asignado
        if (! $tipoUsuario) {
            return response()->json([
                'mensaje' => 'Usuario sin rol asignado.',
                'error' => 'sin_rol',
            ], 403);
        }

        $rolActual = $tipoUsuario->tipo;

        // Verificar si el rol del usuario está en los roles permitidos
        if (! in_array($rolActual, $rolesPermitidos)) {
            return response()->json([
                'mensaje' => 'Acceso denegado. No tiene permisos suficientes.',
                'error' => 'permisos_insuficientes',
                'roles_requeridos' => $rolesPermitidos,
                'rol_actual' => $rolActual,
            ], 403);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Api\Administrador\TemasDeInteres;

use App\Exceptions\TemasDeInteres\TemasDeInteresException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Admin\TemasDeInteresService;
use App\Http\Requests\Administrador\TemasDeInteres\CrearTemaDeInteresRequest;
use App\Http\Requests\Administrador\TemasDeInteres\ActualizarTemaDeInteresRequest;
use Illuminate\Http\JsonResponse;

class TemasDeInteresController extends Controller
{
    public function __construct(
        private TemasDeInteresService $servicioTemasDeInteres)
    {
    }

    /**
     * Funcion para crear un nuevo tema de interés
     */
    public function crearNuevoTemaDeInteres(CrearTemaDeInteresRequest $request): JsonResponse
    {
        try {
            $temaCreado = $this->servicioTemasDeInteres->crearTemaDeInteres(
                $request->validated()
            );

            return response()->json([
                'exito' => true,
                'mensaje' => 'Tema de Interes creado exitosamente',
                'datos' => [
                    'tema' => $temaCreado->load('userCreadorDelTema:id,nombre'),
                ]
            ], Response::HTTP_CREATED);

        } catch (TemasDeInteresException $exception) {
            return response()->json([
                'exito' => false,
                'mensaje' => 'Error al crear el tema de interés',
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para actualizar un tema de interés
     */
    public function actualizarTemaDeInteres(ActualizarTemaDeInteresRequest $request, int $id): JsonResponse
    {
        try {
            $temaActualizado = $this->servicioTemasDeInteres->actualizarTemaDeInteres(
                $id,
                $request->validated()
            );

            return response()->json([
                'exito' => true,
                'mensaje' => 'Tema de Interes actualizado exitosamente',
                'datos' => [
                    'tema' => $temaActualizado,
                ]
            ]);
        } catch (TemasDeInteresException $exception) {
            return response()->json([
                'exito' => false,
                'mensaje' => 'Error al actualizar el tema de interés',
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    // Funcion para eliminar un tema de interés (borrado lógico)
    public function eliminarTemaDeInteres(int $id): JsonResponse
    {
        try {
            $temaEliminado = $this->servicioTemasDeInteres->eliminarTemaDeInteres($id);

            return response()->json([
                'exito' => true,
                'mensaje' => 'Tema de Interes eliminado exitosamente',
                'datos' => [
                    'tema' => $temaEliminado->load('userCreadorDelTema:id,nombre'),
                ]
            ]);
        } catch (TemasDeInteresException $exception) {
            return response()->json([
                'exito' => false,
                'mensaje' => 'Error al eliminar el tema de interés',
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarTemasActivos(): JsonResponse
    {
        try {
            $temasActivos = $this->servicioTemasDeInteres->listarTodosLosTemasActivos();

        return response()->json([
            'exito' => true,
            'mensaje' => 'Temas de interés obtenidos exitosamente',
            'datos' => [
                'temas' => $temasActivos,
                'total' => $temasActivos->count()
            ]
        ]);
        } catch (TemasDeInteresException $exception) {
            return response()->json([
                'exito' => false,
                'mensaje' => 'Error al obtener los temas de interés',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

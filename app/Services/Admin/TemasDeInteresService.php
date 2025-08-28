<?php

namespace App\Services\Admin;

use App\Models\CatTemasDeInteres;
use App\Exceptions\TemasDeInteres\TemasDeInteresException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TemasDeInteresService
{
    public function __construct(private CatTemasDeInteres $modeloTemasDeInteres)
    {
    }
    
    // Funcion para crear el tema de interes
    public function crearTemaDeInteres(array $datos): CatTemasDeInteres
    {
        // Validar que no exista un tema de interes con el mismo nombre
        $this->validarTemaDeInteresQueNoExista($datos['tema']);

        // Crear el tema de interes
        return $this->modeloTemasDeInteres->create([
            'tema' => $this->limpiarTexto($datos['tema']),
            'user_id' => $datos['user_id'],
        ]);
    }

    // Funcion para actualizar el tema de interes
    public function actualizarTemaDeInteres(int $id, array $datos): CatTemasDeInteres
    {
        // Obtener el tema de interes existente
        $tema = $this->obtenerTemaPorId($id);

        // Validar que no exista un tema de interes con el mismo nombre
        $this->validarTemaDeInteresQueNoExista($datos['tema'], $id);

        // Actualizar el tema de interes
        $tema->update([
            'tema' => $this->limpiarTexto($datos['tema']),
        ]);

        // Retornar el tema actualizado
        return $tema->fresh()->load('userCreadorDelTema:id,nombre');
    }

    // Funcion para eliminar un tema de interes por id (Borrado logico)
    public function eliminarTemaDeInteres(int $id): CatTemasDeInteres
    {
        $tema = $this->obtenerTemaPorId($id);

        if (!$tema->estaActivo()) {
            throw new TemasDeInteresException("El tema de interés con ID: {$id} ya está inactivo");
        }

        $tema->eliminarLogicamente();

        return $tema->load('userCreadorDelTema:id,nombre');
    }

    // Listar todos los temas de interes activos
    public function listarTodosLosTemasActivos(): Collection 
    {
        $listado = $this->modeloTemasDeInteres
            ->activos()
            ->with('userCreadorDelTema:id,nombre,apellido_paterno')
            ->orderBy('created_at', 'desc')
            ->get();

        return $listado;
    }

    // Obtener tema de interes por ID
    public function obtenerTemaPorId(int $id): CatTemasDeInteres
    {
        try {
            // Obtener el tema de interes por ID
            return $this->modeloTemasDeInteres->findOrFail($id);
        } catch (ModelNotFoundException) {
            // Manejar la excepción si no se encuentra el tema
            throw new TemasDeInteresException("Tema de interés con ID: {$id} no encontrado");
        }
    }

    // Funcion para validar que no exista un tema de interes con el mismo nombre
    private function validarTemaDeInteresQueNoExista(string $tema, ?int $excluirId = null): void
    {
        // Crear la consulta para buscar el tema
        $query = $this->modeloTemasDeInteres
            ->where('tema', $this->limpiarTexto($tema));

        // Excluir el ID si se proporciona
        if ($excluirId) {
            // Excluir el tema actual de la búsqueda
            $query->where('id', '!=', $excluirId);
        }

        // Verificar si ya existe un tema de interés con el mismo nombre
        if ($query->exists()) {
            // Si existe, lanzar una excepción
            throw new TemasDeInteresException("Ya existe un tema de interés con el mismo nombre");
        }
    }

    // Función para limpiar el texto del tema
    private function limpiarTexto(string $texto): string
    {
        return trim($texto);
    }
}

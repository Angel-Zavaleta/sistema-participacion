<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CatTemasDeInteres extends Model
{
    protected $table = 'cat_temas_de_interes';

    protected $fillable = [
        'tema',
        'user_id',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones con otras tablas

    // 1. Relacion con el Modelo User -> Usuario que creo el tema de interes
    public function userCreadorDelTema()
    {
        // Relacion con el Modelo User -> columna user_id
        return $this->belongsTo(User::class, 'user_id');
    }

    // 2 Scopes para clean code (Temas Activos)
    public function scopeActivos(Builder $query)
    {
        return $query->where('activo', true);
    }

    // 2.1 Scopes para clean code (Temas Inactivos)
    public function scopeInactivos(Builder $query)
    {
        return $query->where('activo', false);
    }

    // 3. Metodos de negocio
    public function estaActivo(): bool
    {
        return $this->activo === true;
    }

    public function activar(): void
    {
        $this->activo = true;
    }

    public function eliminarLogicamente(): void
    {
        $this->activo = false;
        $this->save();
    }

}

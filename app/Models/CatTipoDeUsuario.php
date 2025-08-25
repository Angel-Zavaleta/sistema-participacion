<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatTipoDeUsuario extends Model
{
    /**
     * Nombre de la tabla
     */
    protected $table = 'cat_tipos_de_usuarios';

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'tipo',
        'activo',
    ];

    /**
     * Casts para convertir tipos de datos
     */
    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con usuarios
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'tipo_usuario_id');
    }

    /**
     * Scope para obtener solo tipos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}

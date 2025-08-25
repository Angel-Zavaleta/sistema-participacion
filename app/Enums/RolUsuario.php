<?php

namespace App\Enums;

enum RolUsuario: int
{
    case ADMINISTRADOR = 1;
    case SUPERVISOR = 2;
    case CIUDADANO = 3;
    case COLECTIVO = 4;

    /**
     * Obtiene el nombre del rol en español
     */
    public function etiqueta(): string
    {
        return match ($this) {
            self::ADMINISTRADOR => 'Administrador',
            self::SUPERVISOR => 'Supervisor',
            self::CIUDADANO => 'Ciudadano',
            self::COLECTIVO => 'Colectivo',
        };
    }

    /**
     * Obtiene una descripción del rol
     */
    public function descripcion(): string
    {
        return match ($this) {
            self::ADMINISTRADOR => 'Usuario con acceso completo al sistema',
            self::SUPERVISOR => 'Usuario con permisos de moderación y supervisión',
            self::CIUDADANO => 'Usuario regular del sistema',
            self::COLECTIVO => 'Representante de un colectivo o grupo organizado',
        };
    }

    /**
     * Obtiene todos los roles disponibles
     */
    public static function todos(): array
    {
        return [
            self::ADMINISTRADOR,
            self::SUPERVISOR,
            self::CIUDADANO,
            self::COLECTIVO,
        ];
    }

    /**
     * Obtiene un rol desde un string
     */
    public static function desdeEtiqueta(string $etiqueta): ?self
    {
        return match ($etiqueta) {
            'Administrador' => self::ADMINISTRADOR,
            'Supervisor' => self::SUPERVISOR,
            'Ciudadano' => self::CIUDADANO,
            'Colectivo' => self::COLECTIVO,
            default => null,
        };
    }

    /**
     * Obtiene el nivel jerárquico del rol (para comparaciones si es necesario)
     */
    public function nivelJerarquico(): int
    {
        return match ($this) {
            self::ADMINISTRADOR => 4,
            self::SUPERVISOR => 3,
            self::COLECTIVO => 2,
            self::CIUDADANO => 1,
        };
    }
}

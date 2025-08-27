# Sistema de Participación Ciudadana

Un sistema para la participación ciudadana construido con Laravel 12 y React. Esta es una versiona de migracion y aplicando mejores practicas de desarrollo, principios y react.

## Instalación

1. Clonar repositorio
2. Instalar dependencias:
   ```bash
   composer install
   npm install
   ```
3. Configurar entorno:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Base de datos:
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

## Desarrollo

```bash
# Backend
php artisan serve

# Frontend (en otra terminal)
npm run dev
```

## Comandos útiles

```bash
# Crear controller
php artisan make:controller MiController

# Crear model
php artisan make:model MiModel

# Ejecutar tests (opcional)
./vendor/bin/pest
```

## Git básico

```bash
# Agregar cambios
git add .

# Commit simple
git commit -m "descripción de lo que hice"

# Subir cambios
git push
```

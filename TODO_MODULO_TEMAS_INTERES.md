# 📋 Módulo: Administración de Temas de Interés

## Objetivo
Crear un CRUD completo para que los administradores puedan gestionar los temas de interés del sistema.

## Funcionalidades a implementar
- [ ] **Listar** todos los temas de interés
- [ ] **Crear** nuevos temas de interés
- [ ] **Editar** temas existentes
- [ ] **Eliminar** temas (soft delete)
- [ ] **Buscar y filtrar** temas
- [ ] **Validaciones** de formularios
- [ ] **Autorización** solo para administradores

## Archivos a crear/modificar

### Backend (Laravel)
- [ ] `app/Http/Controllers/Admin/TemasInteresController.php`
- [ ] `app/Http/Requests/TemasInteres/StoreTemasInteresRequest.php`
- [ ] `app/Http/Requests/TemasInteres/UpdateTemasInteresRequest.php`
- [ ] `app/Models/TemaInteres.php` (mejorar modelo existente)
- [ ] `routes/web.php` (agregar rutas)

### Frontend (Inertia + React)
- [ ] `resources/js/Pages/Admin/TemasInteres/Index.tsx`
- [ ] `resources/js/Pages/Admin/TemasInteres/Create.tsx`
- [ ] `resources/js/Pages/Admin/TemasInteres/Edit.tsx`
- [ ] `resources/js/Components/TemasInteres/FormularioTema.tsx`

### Tests
- [ ] `tests/Feature/Admin/TemasInteresControllerTest.php`
- [ ] `tests/Unit/Models/TemaInteresTest.php`

## Estructura de commits planeada
1. `feat(models): mejorar modelo TemaInteres con relationships y scopes`
2. `feat(requests): crear validaciones para temas de interés`
3. `feat(controllers): implementar TemasInteresController con CRUD`
4. `feat(routes): agregar rutas para administración de temas`
5. `feat(views): crear componentes React para gestión de temas`
6. `test(admin): agregar tests para módulo de temas de interés`
7. `docs(temas): documentar API y funcionalidades del módulo`

## Base de datos existente
✅ Tabla `cat_temas_de_interes` ya existe con:
- `id` (increments)
- `tema` (string, 255)
- `user_id` (unsignedInteger, index)
- `timestamps`
- `activo` (tinyInteger, default 1)

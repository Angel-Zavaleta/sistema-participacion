# 🏛️ Sistema de Participación Ciudadana

![Tests](https://github.com/tu-usuario/participacion/workflows/🧪%20Tests%20&%20Quality%20Checks/badge.svg)
![Code Quality](https://github.com/tu-usuario/participacion/workflows/🎨%20Code%20Quality%20&%20Formatting/badge.svg)
![Deploy](https://github.com/tu-usuario/participacion/workflows/🚀%20Deploy/badge.svg)
[![codecov](https://codecov.io/gh/tu-usuario/participacion/branch/main/graph/badge.svg)](https://codecov.io/gh/tu-usuario/participacion)
![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)
![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)
![Node Version](https://img.shields.io/badge/Node-22%2B-green.svg)
![License](https://img.shields.io/badge/license-MIT-blue.svg)

Un sistema moderno para la participación ciudadana construido con Laravel 12, React, TypeScript e Inertia.js.

## 🚀 Características

- ✅ **Control de calidad automatizado** con pre-commit hooks
- 🧪 **Testing completo** (PHP con Pest, Frontend con Vitest)
- 🔄 **CI/CD automatizado** con GitHub Actions
- 📝 **Conventional Commits** para versionado semántico
- 🎨 **Code formatting** automático (Pint, Prettier, ESLint)
- 🔒 **Security scanning** automatizado
- 📊 **Coverage reports** integrados

## 🛠️ Stack Tecnológico

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: React 19, TypeScript, Tailwind CSS
- **Build Tool**: Vite
- **Testing**: Pest (PHP), Vitest (JS/TS)
- **Database**: SQLite (desarrollo), MySQL/PostgreSQL (producción)
- **CI/CD**: GitHub Actions

## 📋 Prerrequisitos

- PHP 8.2 o superior
- Node.js 22 o superior
- Composer
- Git

## 🚀 Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/tu-usuario/participacion.git
   cd participacion
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install
   ```

3. **Configurar entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar base de datos**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```

5. **Inicializar herramientas de desarrollo**
   ```bash
   npm run prepare
   ```

## 🏃‍♂️ Comandos de Desarrollo

### Backend
```bash
# Servidor de desarrollo
php artisan serve

# Ejecutar tests
./vendor/bin/pest

# Tests con coverage
./vendor/bin/pest --coverage

# Formatear código
./vendor/bin/pint
```

### Frontend
```bash
# Servidor de desarrollo
npm run dev

# Build para producción
npm run build

# Tests
npm run test

# Tests con UI
npm run test --ui

# Coverage
npm run test:coverage

# Linting y formateo
npm run lint
npm run format
```

### Full CI Pipeline Local
```bash
# Ejecutar todos los checks como en CI
npm run ci
```

## 🔄 Workflow de Desarrollo

### 1. Branches
- `main`: Producción estable
- `develop`: Desarrollo e integración
- `feature/*`: Nuevas funcionalidades
- `fix/*`: Correcciones de bugs
- `hotfix/*`: Correcciones urgentes en producción

### 2. Conventional Commits
Usa el formato estándar para commits:

```
tipo(scope): descripción

feat(auth): add user registration endpoint
fix(database): resolve connection timeout
docs: update installation guide
```

**Tipos disponibles:**
- `feat`: Nueva funcionalidad
- `fix`: Corrección de bug
- `docs`: Solo documentación
- `style`: Formateo de código
- `refactor`: Refactoring sin cambios funcionales
- `perf`: Mejoras de rendimiento
- `test`: Añadir o corregir tests
- `chore`: Tareas de mantenimiento

### 3. Pre-commit Hooks
Se ejecutan automáticamente antes de cada commit:
- ✅ Formateo de código (Pint + Prettier)
- ✅ Linting (ESLint)
- ✅ Type checking (TypeScript)
- ✅ Tests

### 4. Pull Requests
1. Crear rama desde `develop`
2. Implementar cambios
3. Push y crear PR hacia `develop`
4. Los checks de CI deben pasar
5. Code review requerido
6. Merge después de aprobación

## 🚀 Deployment

### Ambientes

#### Staging (develop branch)
- Deploy automático en cada push a `develop`
- Tests completos antes del deploy
- Ambiente para QA y testing

#### Production (main branch)
- Deploy automático en cada push a `main`
- Requiere passing de todos los tests
- Ambiente protegido con environments

### Manual Deploy
```bash
# Crear release
npm run release

# Push tags
git push --follow-tags origin main
```

## 📊 Monitoreo y Quality Gates

### Coverage Mínimo
- **PHP**: 80%
- **Frontend**: 70%

### Quality Gates
- ✅ All tests passing
- ✅ Code coverage above threshold
- ✅ No linting errors
- ✅ No security vulnerabilities
- ✅ Build successful

## 🐛 Troubleshooting

### Hooks no funcionan
```bash
# Reinstalar hooks
rm -rf .husky
npm run prepare
```

### Tests fallan localmente
```bash
# Limpiar cache y reinstalar
composer install --optimize-autoloader
npm ci
php artisan config:clear
php artisan cache:clear
```

### Build falla
```bash
# Verificar versiones
php --version  # >= 8.2
node --version # >= 22
npm --version  # >= 10
```

## 📚 Documentación Adicional

- [API Documentation](./docs/api.md)
- [Frontend Components](./docs/components.md)
- [Database Schema](./docs/database.md)
- [Deployment Guide](./docs/deployment.md)

## 🤝 Contribuir

1. Fork del proyecto
2. Crear rama feature (`git checkout -b feature/amazing-feature`)
3. Commit cambios (`git commit -m 'feat: add amazing feature'`)
4. Push a la rama (`git push origin feature/amazing-feature`)
5. Abrir Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver [LICENSE](LICENSE) para más detalles.

## 👥 Team

- **Tech Lead**: Tu Nombre
- **Backend**: Tu Nombre
- **Frontend**: Tu Nombre

---

⚡ **Powered by**: Laravel 12 + React + TypeScript + ❤️

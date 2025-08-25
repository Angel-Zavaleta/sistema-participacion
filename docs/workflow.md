# 🔄 Workflow de Desarrollo

## Estrategia de Branching

### Git Flow Simplificado

```
main (producción)
├── develop (desarrollo)
│   ├── feature/auth-system
│   ├── feature/user-dashboard
│   └── feature/voting-module
├── hotfix/critical-bug
└── release/v1.0.0
```

### Branches Principales

#### `main`
- **Propósito**: Código en producción
- **Protección**: Requiere PR review + CI passing
- **Deploy**: Automático a producción
- **Nunca**: Commit directo

#### `develop`
- **Propósito**: Integración de features
- **Deploy**: Automático a staging
- **Testing**: Ambiente de QA
- **Merge**: Features completadas

### Branches de Trabajo

#### `feature/*`
```bash
# Crear feature branch
git checkout develop
git pull origin develop
git checkout -b feature/user-registration

# Desarrollo...
git add .
git commit -m "feat(auth): add user registration form"

# Push y crear PR
git push origin feature/user-registration
```

#### `fix/*`
```bash
# Para bugs en develop
git checkout develop
git checkout -b fix/login-validation

# Para hotfixes en producción
git checkout main
git checkout -b hotfix/security-patch
```

## Conventional Commits

### Formato
```
<tipo>[scope]: <descripción>

[cuerpo opcional]

[footer opcional]
```

### Tipos Permitidos
- `feat`: Nueva funcionalidad
- `fix`: Corrección de bug
- `docs`: Solo documentación
- `style`: Formateo (sin cambios lógicos)
- `refactor`: Refactoring sin nuevas features
- `perf`: Mejoras de performance
- `test`: Añadir o modificar tests
- `chore`: Tareas de mantenimiento
- `ci`: Cambios en CI/CD
- `build`: Cambios en build system

### Ejemplos
```bash
# Feature nueva
git commit -m "feat(auth): add OAuth2 integration"

# Bug fix
git commit -m "fix(dashboard): resolve chart rendering issue"

# Breaking change
git commit -m "feat(api)!: change user endpoint structure

BREAKING CHANGE: User API now returns nested user object"

# Con scope y detalles
git commit -m "feat(voting): implement real-time vote counting

- Add WebSocket connection for live updates
- Implement vote validation middleware
- Add vote persistence with Redis"
```

## Versionado Semántico

### Formato: `MAJOR.MINOR.PATCH`

- **MAJOR**: Breaking changes
- **MINOR**: Nuevas features (backward compatible)
- **PATCH**: Bug fixes

### Automatizado con Standard Version
```bash
# Release automático basado en commits
npm run release

# Tipos específicos
npm run release -- --release-as minor
npm run release -- --release-as major
npm run release -- --prerelease alpha
```

## Pull Request Workflow

### 1. Preparación
```bash
# Actualizar develop
git checkout develop
git pull origin develop

# Rebase tu feature
git checkout feature/my-feature
git rebase develop
```

### 2. Template de PR
```markdown
## 🎯 Descripción
Breve descripción de los cambios realizados.

## 🔍 Tipo de Cambio
- [ ] Bug fix (no breaking change)
- [ ] Nueva feature (no breaking change) 
- [ ] Breaking change (fix o feature que causa cambios incompatibles)
- [ ] Documentación

## 🧪 Testing
- [ ] Tests unitarios pasando
- [ ] Tests de integración pasando
- [ ] Pruebas manuales realizadas

## 📝 Checklist
- [ ] Mi código sigue el style guide del proyecto
- [ ] He realizado self-review de mi código
- [ ] He comentado código complejo
- [ ] He actualizado documentación si es necesario
- [ ] Mis commits siguen conventional commits
```

### 3. Review Process
1. **Automated Checks**: CI debe pasar
2. **Code Review**: Al menos 1 aprobación
3. **Manual Testing**: En ambiente de staging
4. **Security Review**: Para cambios sensibles

## Quality Gates

### Pre-commit (Automático)
- ✅ Code formatting (Pint + Prettier)
- ✅ Linting (ESLint + PHPStan)
- ✅ Type checking (TypeScript)
- ✅ Unit tests

### CI Pipeline
- ✅ Multi-PHP version testing
- ✅ Frontend tests (Vitest)
- ✅ Security scan
- ✅ Coverage threshold (80% PHP, 70% JS)
- ✅ Build verification

### Pre-merge
- ✅ All CI checks passing
- ✅ Code review approved
- ✅ Up-to-date with target branch
- ✅ Conventional commit format

## Ambientes

### Development (Local)
```bash
# Configuración local
cp .env.example .env.local
php artisan key:generate
npm run dev
```

### Staging (develop branch)
- **URL**: https://staging-participacion.app
- **Deploy**: Automático en push a `develop`
- **Propósito**: Testing y QA
- **Base de datos**: Separada de producción

### Production (main branch)
- **URL**: https://participacion.app
- **Deploy**: Automático en push a `main`
- **Protección**: Environment protection rules
- **Rollback**: Capacidad de revertir

## Hotfix Workflow

### Para Bugs Críticos en Producción
```bash
# 1. Crear hotfix desde main
git checkout main
git pull origin main
git checkout -b hotfix/critical-security-fix

# 2. Implementar fix mínimo
# ... hacer cambios necesarios ...

# 3. Commit siguiendo convenciones
git commit -m "fix(security): patch XSS vulnerability in user input"

# 4. PR directo a main (excepcional)
git push origin hotfix/critical-security-fix

# 5. Después del merge, actualizar develop
git checkout develop
git merge main
git push origin develop
```

## Comandos Útiles

### Setup Inicial
```bash
# Clonar y configurar
git clone https://github.com/usuario/participacion.git
cd participacion
composer install
npm install
cp .env.example .env
php artisan key:generate
npm run prepare  # Instala hooks
```

### Desarrollo Diario
```bash
# Sincronizar con remoto
git checkout develop
git pull origin develop

# Crear feature
git checkout -b feature/mi-feature

# Desarrollo iterativo
npm run dev  # Terminal 1: Frontend
php artisan serve  # Terminal 2: Backend

# Testing continuo
npm run test:watch  # Tests JS en watch mode
./vendor/bin/pest --watch  # Tests PHP en watch mode
```

### Pre-release
```bash
# Verificar todo funciona
npm run ci  # Full CI pipeline local
./vendor/bin/pest  # Tests completos PHP

# Crear release
npm run release
git push --follow-tags origin main
```

## Debugging

### Git Issues
```bash
# Resetear a último commit
git reset --hard HEAD

# Limpiar archivos no tracked
git clean -fd

# Ver historial visual
git log --oneline --graph --all

# Revertir commit específico
git revert <commit-hash>
```

### CI/CD Issues
```bash
# Ejecutar localmente lo mismo que CI
npm run ci
./vendor/bin/pest --coverage

# Debug GitHub Actions
# Ver logs en: Actions tab > Failed job > Step details
```

### Hooks Issues
```bash
# Reinstalar hooks
rm -rf .husky
npm run prepare

# Saltarse hooks (emergencia)
git commit --no-verify -m "emergency fix"
```

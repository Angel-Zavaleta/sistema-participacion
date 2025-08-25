# 🚀 Guía de Despliegue

## Opciones de Hosting Gratuito

### 1. GitHub Pages + GitHub Actions (Solo Frontend)
Si solo necesitas desplegar el frontend estático:
```yaml
# .github/workflows/pages.yml
name: Deploy to GitHub Pages
on:
  push:
    branches: [ main ]
jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Setup Node
        uses: actions/setup-node@v4
        with:
          node-version: '22'
      - run: npm ci
      - run: npm run build
      - name: Deploy to GitHub Pages
        uses: peaceiris/actions-gh-pages@v3
        with:
          github_token: ${{ secrets.GITHUB_TOKEN }}
          publish_dir: ./public/build
```

### 2. Railway (Full Stack)
1. Conecta tu repositorio en [Railway](https://railway.app)
2. Agrega las variables de entorno
3. Railway detectará automáticamente Laravel

### 3. Heroku (Full Stack)
```bash
# Instalar Heroku CLI
heroku create tu-app-participacion
heroku config:set APP_KEY=$(php artisan key:generate --show)
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
git push heroku main
```

### 4. Vercel (Full Stack con Serverless)
1. Instala Vercel CLI: `npm i -g vercel`
2. Configura `vercel.json`:
```json
{
  "functions": {
    "api/index.php": {
      "runtime": "vercel-php@0.6.0"
    }
  },
  "routes": [
    { "src": "/api/(.*)", "dest": "/api/index.php" },
    { "src": "/(.*)", "dest": "/public/$1" }
  ]
}
```

### 5. PlanetScale + Netlify
- **Base de datos**: PlanetScale (MySQL gratuito)
- **Frontend**: Netlify
- **Backend API**: Netlify Functions

## Variables de Entorno Requeridas

```env
# Básicas
APP_NAME="Sistema Participación"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Base de datos (ejemplo Railway)
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=6543
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=xxx

# Mail (ejemplo Mailtrap gratuito)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxx
MAIL_PASSWORD=xxx
```

## Scripts de Deploy

### Deploy Manual
```bash
# 1. Build assets
npm run build

# 2. Optimizar Composer
composer install --optimize-autoloader --no-dev

# 3. Caché de configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Migraciones
php artisan migrate --force
```

### Health Check Endpoint
```php
// routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => config('app.version', '1.0.0')
    ]);
});
```

## Monitoreo Gratuito

### 1. UptimeRobot
- Monitoreo de uptime gratuito
- Alertas por email/SMS
- Dashboard público

### 2. Sentry (Logging de Errores)
```bash
composer require sentry/sentry-laravel
php artisan sentry:publish --dsn=tu-dsn
```

### 3. LogRocket (Solo Frontend)
```javascript
// resources/js/app.tsx
import LogRocket from 'logrocket';
LogRocket.init('app/id');
```

## Optimizaciones de Performance

### Backend
```php
// config/app.php
'debug' => env('APP_DEBUG', false),

// Optimizaciones en .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Frontend
```javascript
// vite.config.ts
export default defineConfig({
  build: {
    rollupOptions: {
      output: {
        manualChunks: {
          vendor: ['react', 'react-dom'],
          utils: ['@inertiajs/react']
        }
      }
    }
  }
})
```

## SSL y Dominio Gratuito

### 1. Cloudflare
- DNS gratuito
- SSL automático
- CDN global
- DDoS protection

### 2. Let's Encrypt (si usas VPS)
```bash
certbot --nginx -d tu-dominio.com
```

## Backup Automatizado

### Base de Datos
```bash
# Crontab
0 2 * * * mysqldump -u user -p database > backup_$(date +\%Y\%m\%d).sql
```

### Código
- GitHub ya sirve como backup
- Usar GitHub Releases para versiones

## Troubleshooting Deploy

### Error 500
1. Verificar permisos: `chmod -R 755 storage bootstrap/cache`
2. Revisar logs: `tail -f storage/logs/laravel.log`
3. Verificar .env

### Assets no cargan
1. Verificar `APP_URL` en .env
2. Ejecutar `php artisan storage:link`
3. Verificar rutas en Vite

### Base de datos
1. Verificar conexión: `php artisan tinker` → `DB::connection()->getPdo()`
2. Ejecutar migraciones: `php artisan migrate:status`

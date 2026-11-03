# RhythmRun

Aplicación para crear retos de running, compartir resultados y seguir la
actividad de otras personas. Todo el código vive en un único repositorio Git y
se organiza en dos aplicaciones independientes:

- `backend/`: API JSON Laravel.
- `frontend/`: aplicación web Vue 3.

Ambas partes se despliegan por separado. Los nombres de tablas, campos y rutas
API se conservan para no romper datos o clientes; el código propio y la
interfaz usan nombres en español. Los directorios y puntos de entrada que
requiere Laravel/Vue mantienen sus convenciones.

## Requisitos

- PHP 8.3+ y Composer.
- Node.js 20.19+ (o 22.12+) y npm.
- MySQL/PostgreSQL recomendado en producción; SQLite sirve para desarrollo.

## Preparación local

### API

```powershell
cd backend
Copy-Item .env.example .env
composer install
php artisan key:generate
if (-not (Test-Path database\database.sqlite)) { New-Item -ItemType File database\database.sqlite | Out-Null }
php artisan migrate
php artisan serve
```

La API queda disponible en `http://127.0.0.1:8000`.

### Aplicación web

En otra terminal:

```powershell
cd frontend
npm ci
npm run dev
```

Vite reenvía `/api` a `http://127.0.0.1:8000`. Puedes cambiar el destino local
con `VITE_API_PROXY_TARGET`. El frontend no requiere credenciales de servicios
externos.

## Producción

Configura en la plataforma de la API `APP_ENV=production`, `APP_DEBUG=false`,
una `APP_KEY` única, la URL pública, las credenciales de una base de datos
persistente y `FRONTEND_URL` con el origen HTTPS exacto del frontend. No subas
el archivo `.env` al repositorio ni publiques nada fuera de `backend/public`.

Despliega la API instalando las dependencias de producción y ejecutando:

```powershell
cd backend
php artisan migrate --force
php artisan optimize
```

Para compilar la web, define `VITE_API_BASE_URL` con la URL pública de la API
terminada en `/api` y ejecuta:

```powershell
cd frontend
npm ci
npm run build
```

Publica `frontend/dist` en un hosting estático con fallback de rutas a
`index.html`. Configura CORS en la API con `FRONTEND_URL`.

## Pruebas y Git

Desde `backend`, ejecuta `php artisan test`. Desde `frontend`, ejecuta
`npm run build`. El `.gitignore` de la raíz excluye secretos, dependencias,
base de datos local y artefactos generados.

Todo el proyecto se versiona desde esta carpeta raíz. Para subirlo a un remoto:

```powershell
git status
git remote add origin https://github.com/usuario/repositorio.git
git push -u origin main
```

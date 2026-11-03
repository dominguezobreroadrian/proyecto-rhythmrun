# Aplicación web de RhythmRun

Aplicación Vue 3 con Vite, ubicada en `frontend/` y desplegada por separado de
la API Laravel. Consulta el [README principal](../README.md) para el despliegue.

## Desarrollo local

```sh
npm ci
npm run dev
```

Vite envía las peticiones `/api` a `http://127.0.0.1:8000`. Puedes cambiar el
destino con `VITE_API_PROXY_TARGET` en `.env.local`.

## Compilación de producción

Antes de compilar para producción, define `VITE_API_BASE_URL` con la URL pública
de la API terminada en `/api`. En desarrollo basta con el proxy local. Ejecuta:

```sh
npm ci
npm run build
```

Publica el directorio generado `dist/` y configura una regla de fallback a
`index.html` para las rutas de Vue Router.

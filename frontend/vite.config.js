import { fileURLToPath, URL } from 'node:url'

import { defineConfig, loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), 'VITE_')

    return {
        plugins: [
        vue(),
        tailwindcss(),
        ],
        server: {
        proxy: {
            '/api': {
            target: env.VITE_API_PROXY_TARGET || 'http://127.0.0.1:8000',
            changeOrigin: true,
            },
        },
        },
        resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url))
        },
        },
    }
})

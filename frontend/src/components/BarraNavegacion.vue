<template>
    <div>
        <nav class="flex items-center justify-between bg-gray-900 px-6 py-4 shadow-lg">
            <RouterLink to="/retos" class="text-xl font-bold text-green-400">RhythmRun</RouterLink>
            <div class="flex items-center gap-4">
                <RouterLink to="/retos" class="text-gray-300 transition hover:text-white">Retos</RouterLink>
                <RouterLink to="/actividad" class="text-gray-300 transition hover:text-white">Actividad</RouterLink>
                <RouterLink to="/clasificacion" class="text-gray-300 transition hover:text-white">Clasificación</RouterLink>
                <button
                    type="button"
                    class="rounded-lg bg-red-500/20 px-3 py-1 text-red-400 transition hover:bg-red-500/40"
                    @click="cerrarSesion"
                >
                Salir
                </button>
            </div>
        </nav>
        <p v-if="error" role="alert" class="mx-auto mt-4 max-w-4xl rounded-lg bg-red-500/20 p-3 text-red-300">
        {{ error }}
        </p>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAutenticacion } from '../stores/autenticacion'

const autenticacion = useAutenticacion()
const router = useRouter()
const error = ref('')

async function cerrarSesion() {
    error.value = ''
    try {
        await autenticacion.cerrarSesion()
        await router.push('/acceso')
    } catch (e) {
        error.value = e.response?.data?.message || 'No se pudo cerrar la sesión.'
    }
}
</script>

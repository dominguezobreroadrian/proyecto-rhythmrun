<template>
    <div class="min-h-screen bg-gray-950 text-white">
        <BarraNavegacion />

        <div class="max-w-4xl mx-auto px-6 py-8">

        <form class="mb-8 rounded-2xl bg-gray-900 p-6" @submit.prevent="crearReto">
            <h2 class="mb-4 text-xl font-bold">Crear nuevo reto</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <input v-model="formulario.title" required maxlength="255" type="text" placeholder="Título del reto"
                class="col-span-2 rounded-lg bg-gray-800 px-4 py-3 outline-none focus:ring-2 focus:ring-green-500" />
            <input v-model="formulario.description" type="text" placeholder="Descripción (opcional)"
                class="col-span-2 rounded-lg bg-gray-800 px-4 py-3 outline-none focus:ring-2 focus:ring-green-500" />
            <input v-model="formulario.playlist_name" maxlength="255" type="text" placeholder="Música o lista (opcional)"
                class="rounded-lg bg-gray-800 px-4 py-3 outline-none focus:ring-2 focus:ring-green-500" />
            <input v-model="formulario.distance_km" required min="0.1" step="0.1" type="number" placeholder="Distancia (km)"
                class="rounded-lg bg-gray-800 px-4 py-3 outline-none focus:ring-2 focus:ring-green-500" />
            <button :disabled="cargando" type="submit"
                class="rounded-lg bg-green-500 py-3 font-bold text-black transition hover:bg-green-400 disabled:opacity-50">
                {{ cargando ? 'Creando...' : '+ Crear reto' }}
            </button>
            </div>
        </form>

        <p v-if="error" role="alert" class="mb-4 rounded-lg bg-red-500/20 p-3 text-red-300">{{ error }}</p>

        <!-- Lista de retos -->
        <h2 class="text-xl font-bold mb-4">Todos los retos</h2>

        <div v-if="retos.length === 0" class="text-gray-500 text-center py-12">
            No hay retos aún. ¡Crea el primero!
        </div>

        <div class="flex flex-col gap-4">
            <div v-for="reto in retos" :key="reto.id"
            class="bg-gray-900 rounded-2xl p-6 hover:ring-2 hover:ring-green-500/30 transition">
            <div class="flex justify-between items-start">
                <div>
                <h3 class="text-lg font-bold">{{ reto.title }}</h3>
                <p class="text-gray-400 text-sm mt-1">{{ reto.description }}</p>
                <div class="flex gap-4 mt-3 text-sm text-gray-400">
                    <span>🏃 {{ reto.distance_km }} km</span>
                    <span v-if="reto.playlist_name">🎵 {{ reto.playlist_name }}</span>
                    <span>👤 {{ reto.user?.name }}</span>
                </div>
                </div>
                <button @click="eliminarReto(reto.id)"
                v-if="reto.user_id === autenticacion.usuario?.id"
                class="text-red-400 hover:text-red-300 text-sm">
                Eliminar
                </button>
            </div>

            <!-- Enviar resultado -->
            <div class="mt-4 pt-4 border-t border-gray-800">
                <div class="flex gap-3">
                <input v-model="formularioResultado[reto.id + '_time']" min="0.1" step="0.1" type="number" placeholder="Tiempo (min)"
                    class="bg-gray-800 px-3 py-2 rounded-lg text-sm outline-none focus:ring-2 focus:ring-green-500 w-36" />
                <input v-model="formularioResultado[reto.id + '_distance']" min="0.1" step="0.1" type="number" placeholder="Distancia (km)"
                    class="bg-gray-800 px-3 py-2 rounded-lg text-sm outline-none focus:ring-2 focus:ring-green-500 w-36" />
                <button @click="enviarResultado(reto.id)"
                    class="bg-green-500/20 text-green-400 px-4 py-2 rounded-lg text-sm hover:bg-green-500/40 transition">
                    Enviar resultado
                </button>
                </div>
            </div>
            </div>
        </div>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'
import { useAutenticacion } from '../stores/autenticacion'
import clienteApi from '../api/clienteApi'
import BarraNavegacion from '../components/BarraNavegacion.vue'

const autenticacion = useAutenticacion()
const retos = ref([])
const cargando = ref(false)
const error = ref('')
const formularioResultado = reactive({})
const formulario = reactive({
    title: '',
    description: '',
    playlist_name: '',
    distance_km: '',
})

async function cargarRetos() {
    try {
        const { data } = await clienteApi.get('/challenges')
        retos.value = data
    } catch (e) {
        error.value = e.response?.data?.message || 'No se pudieron cargar los retos.'
    }
}

async function crearReto() {
    error.value = ''
    cargando.value = true
    try {
        await clienteApi.post('/challenges', {
        ...formulario,
        playlist_id: null,
        playlist_name: formulario.playlist_name || null,
        })
        formulario.title = ''
        formulario.description = ''
        formulario.playlist_name = ''
        formulario.distance_km = ''
        await cargarRetos()
    } catch (e) {
        error.value = e.response?.data?.message || 'No se pudo crear el reto.'
    } finally {
        cargando.value = false
    }
}

async function eliminarReto(id) {
    error.value = ''
    try {
        await clienteApi.delete(`/challenges/${id}`)
        await cargarRetos()
    } catch (e) {
        error.value = e.response?.data?.message || 'No se pudo eliminar el reto.'
    }
}

async function enviarResultado(idReto) {
    error.value = ''
    try {
        await clienteApi.post(`/challenges/${idReto}/results`, {
        time_minutes: formularioResultado[idReto + '_time'],
        distance_km: formularioResultado[idReto + '_distance'],
        })
        delete formularioResultado[idReto + '_time']
        delete formularioResultado[idReto + '_distance']
        await cargarRetos()
    } catch (e) {
        error.value = e.response?.data?.message || 'No se pudo enviar el resultado.'
    }
}

onMounted(cargarRetos)
</script>

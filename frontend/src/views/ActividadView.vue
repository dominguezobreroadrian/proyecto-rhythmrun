<template>
  <div class="min-h-screen bg-gray-950 text-white">
    <BarraNavegacion />

    <div class="max-w-4xl mx-auto px-6 py-8">
      <h2 class="text-xl font-bold mb-6">Actividad de las personas que sigues</h2>
      <p v-if="error" role="alert" class="mb-4 rounded-lg bg-red-500/20 p-3 text-red-300">{{ error }}</p>

      <div v-if="actividad.length === 0" class="text-gray-500 text-center py-12">
        Todavía no hay actividad. ¡Sigue a otras personas para ver sus retos!
      </div>

      <div class="flex flex-col gap-4">
        <div v-for="reto in actividad" :key="reto.id"
          class="bg-gray-900 rounded-2xl p-6">
          <h3 class="text-lg font-bold">{{ reto.title }}</h3>
          <p class="text-gray-400 text-sm mt-1">{{ reto.description }}</p>
          <div class="flex gap-4 mt-3 text-sm text-gray-400">
            <span>🏃 {{ reto.distance_km }} km</span>
            <span v-if="reto.playlist_name">🎵 {{ reto.playlist_name }}</span>
            <span>👤 {{ reto.user?.name }}</span>
            <span>✅ {{ reto.results_count }} resultados</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import clienteApi from '../api/clienteApi'
import BarraNavegacion from '../components/BarraNavegacion.vue'

const actividad = ref([])
const error = ref('')

async function cargarActividad() {
  try {
    const { data } = await clienteApi.get('/feed')
    actividad.value = data
  } catch (e) {
    error.value = e.response?.data?.message || 'No se pudo cargar la actividad.'
  }
}

onMounted(cargarActividad)
</script>
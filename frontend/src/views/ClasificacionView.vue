<template>
  <div class="min-h-screen bg-gray-950 text-white">
    <BarraNavegacion />

    <div class="max-w-4xl mx-auto px-6 py-8">
      <h2 class="text-xl font-bold mb-6">Clasificación global 🏆</h2>
      <p v-if="error" role="alert" class="mb-4 rounded-lg bg-red-500/20 p-3 text-red-300">{{ error }}</p>

      <div class="bg-gray-900 rounded-2xl overflow-hidden">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-800">
              <th class="text-left px-6 py-4 text-gray-400">#</th>
              <th class="text-left px-6 py-4 text-gray-400">Usuario</th>
              <th class="text-left px-6 py-4 text-gray-400">Retos completados</th>
              <th class="text-left px-6 py-4 text-gray-400">Media (min)</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(entrada, indice) in clasificacion" :key="entrada.user_id"
              class="border-b border-gray-800 hover:bg-gray-800/50 transition">
              <td class="px-6 py-4">
                <span v-if="indice === 0">🥇</span>
                <span v-else-if="indice === 1">🥈</span>
                <span v-else-if="indice === 2">🥉</span>
                <span v-else class="text-gray-500">{{ indice + 1 }}</span>
              </td>
              <td class="px-6 py-4 font-medium">{{ entrada.user?.name }}</td>
              <td class="px-6 py-4 text-green-400 font-bold">{{ entrada.retos_completados }}</td>
              <td class="px-6 py-4 text-gray-400">{{ Math.round(entrada.media_minutos) }} min</td>
            </tr>
          </tbody>
        </table>

        <div v-if="clasificacion.length === 0" class="text-gray-500 text-center py-12">
          Aún no hay resultados. ¡Sé el primero!
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import clienteApi from '../api/clienteApi'
import BarraNavegacion from '../components/BarraNavegacion.vue'

const clasificacion = ref([])
const error = ref('')

async function cargarClasificacion() {
  try {
    const { data } = await clienteApi.get('/ranking')
    clasificacion.value = data
  } catch (e) {
    error.value = e.response?.data?.message || 'No se pudo cargar la clasificación.'
  }
}

onMounted(cargarClasificacion)
</script>

<template>
  <div class="min-h-screen bg-gray-950 flex items-center justify-center">
    <div class="bg-gray-900 p-8 rounded-2xl w-full max-w-md shadow-xl">

      <h1 class="text-3xl font-bold text-white mb-2">RhythmRun</h1>
      <p class="text-gray-400 mb-6">Inicia sesión para continuar</p>

      <div v-if="error" class="bg-red-500/20 text-red-400 p-3 rounded-lg mb-4">
        {{ error }}
      </div>

      <div class="flex flex-col gap-4">
        <input
          v-model="correo"
          type="email"
          placeholder="Correo electrónico"
          class="bg-gray-800 text-white px-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-green-500"
        />
        <input
          v-model="contrasena"
          type="password"
          placeholder="Contraseña"
          class="bg-gray-800 text-white px-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-green-500"
        />
        <button
          @click="iniciarSesion"
          :disabled="cargando"
          class="bg-green-500 hover:bg-green-400 text-black font-bold py-3 rounded-lg transition"
        >
          {{ cargando ? 'Cargando...' : 'Iniciar sesión' }}
        </button>
      </div>

      <p class="text-gray-400 mt-6 text-center">
        ¿No tienes cuenta?
        <RouterLink to="/registro" class="text-green-400 hover:underline">Regístrate</RouterLink>
      </p>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAutenticacion } from '../stores/autenticacion'

const autenticacion = useAutenticacion()
const router = useRouter()

const correo = ref('')
const contrasena = ref('')
const error = ref('')
const cargando = ref(false)

async function iniciarSesion() {
  error.value = ''
  cargando.value = true
  try {
    await autenticacion.iniciarSesion(correo.value, contrasena.value)
    router.push('/retos')
  } catch {
    error.value = 'Correo o contraseña incorrectos.'
  } finally {
    cargando.value = false
  }
}
</script>
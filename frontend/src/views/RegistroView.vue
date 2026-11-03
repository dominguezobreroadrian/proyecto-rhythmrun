<template>
  <div class="min-h-screen bg-gray-950 flex items-center justify-center">
    <div class="bg-gray-900 p-8 rounded-2xl w-full max-w-md shadow-xl">

      <h1 class="text-3xl font-bold text-white mb-2">RhythmRun </h1>
      <p class="text-gray-400 mb-6">Crea tu cuenta</p>

      <div v-if="error" class="bg-red-500/20 text-red-400 p-3 rounded-lg mb-4">
        {{ error }}
      </div>

      <div class="flex flex-col gap-4">
        <input
          v-model="nombre"
          type="text"
          placeholder="Nombre"
          class="bg-gray-800 text-white px-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-green-500"
        />
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
        <input
          v-model="confirmacionContrasena"
          type="password"
          placeholder="Confirmar contraseña"
          class="bg-gray-800 text-white px-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-green-500"
        />
        <button
          @click="registrar"
          :disabled="cargando"
          class="bg-green-500 hover:bg-green-400 text-black font-bold py-3 rounded-lg transition"
        >
          {{ cargando ? 'Cargando...' : 'Crear cuenta' }}
        </button>
      </div>

      <p class="text-gray-400 mt-6 text-center">
        ¿Ya tienes cuenta?
        <RouterLink to="/acceso" class="text-green-400 hover:underline">Inicia sesión</RouterLink>
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

const nombre = ref('')
const correo = ref('')
const contrasena = ref('')
const confirmacionContrasena = ref('')
const error = ref('')
const cargando = ref(false)

async function registrar() {
  error.value = ''
  cargando.value = true
  try {
    await autenticacion.registrar(nombre.value, correo.value, contrasena.value, confirmacionContrasena.value)
    router.push('/retos')
  } catch {
    error.value = 'Error al registrarse. Comprueba los datos.'
  } finally {
    cargando.value = false
  }
}
</script>

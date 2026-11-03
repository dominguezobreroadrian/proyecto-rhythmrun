<template>
  <main class="min-h-screen bg-gray-950 text-white">
    <header class="mx-auto flex max-w-6xl items-center justify-between px-6 py-6">
      <RouterLink to="/" class="text-xl font-bold text-green-400">RhythmRun</RouterLink>
      <nav class="flex items-center gap-4">
        <RouterLink
          v-if="autenticacion.estaAutenticado"
          to="/retos"
          class="text-gray-300 transition hover:text-white"
        >
          Mis retos
        </RouterLink>
        <template v-else>
          <RouterLink to="/acceso" class="text-gray-300 transition hover:text-white">
            Iniciar sesión
          </RouterLink>
          <RouterLink
            to="/registro"
            class="rounded-lg bg-green-500 px-4 py-2 font-semibold text-black transition hover:bg-green-400"
          >
            Crear cuenta
          </RouterLink>
        </template>
      </nav>
    </header>

    <section class="mx-auto grid max-w-6xl gap-12 px-6 py-20 md:grid-cols-2 md:items-center">
      <div>
        <p class="mb-4 font-semibold uppercase tracking-[0.2em] text-green-400">
          Corre a tu ritmo
        </p>
        <h1 class="text-5xl font-bold leading-tight md:text-6xl">
          La música también se mide en kilómetros.
        </h1>
        <p class="mt-6 max-w-xl text-lg leading-8 text-gray-400">
          Crea retos para correr con tus listas de reproducción, comparte tus resultados y descubre cómo
          entrenan tus amigos.
        </p>
        <RouterLink
          :to="autenticacion.estaAutenticado ? '/retos' : '/registro'"
          class="mt-8 inline-flex rounded-lg bg-green-500 px-6 py-3 font-bold text-black transition hover:bg-green-400"
        >
          {{ autenticacion.estaAutenticado ? 'Ver retos' : 'Empieza a correr' }}
        </RouterLink>
      </div>

      <div class="rounded-3xl border border-green-500/20 bg-gradient-to-br from-green-500/15 to-gray-900 p-8">
        <div class="rounded-2xl bg-gray-900/80 p-6">
          <p class="text-sm font-semibold uppercase tracking-wider text-gray-400">Tu próximo reto</p>
          <p class="mt-4 text-3xl font-bold">5 km</p>
          <div class="mt-6 h-2 overflow-hidden rounded-full bg-gray-700">
            <div class="h-full w-2/3 rounded-full bg-green-400"></div>
          </div>
          <p class="mt-3 text-sm text-gray-400">Corre, registra tu tiempo y supera tu marca.</p>
        </div>
      </div>
    </section>
  </main>
</template>

<script setup>
import { useAutenticacion } from '../stores/autenticacion'

const autenticacion = useAutenticacion()
</script>

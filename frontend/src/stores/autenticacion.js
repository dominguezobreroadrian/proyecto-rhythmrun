import { defineStore } from 'pinia'
import clienteApi from '../api/clienteApi'

export const useAutenticacion = defineStore('autenticacion', {
  state: () => ({
    usuario: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
  }),

  getters: {
    estaAutenticado: (state) => !!state.token,
  },

  actions: {
    async registrar(nombre, correo, contrasena, confirmacionContrasena) {
      const { data } = await clienteApi.post('/register', {
        name: nombre,
        email: correo,
        password: contrasena,
        password_confirmation: confirmacionContrasena,
      })
      this.token = data.token
      this.usuario = data.user
      localStorage.setItem('token', data.token)
      localStorage.setItem('user', JSON.stringify(data.user))
    },

    async iniciarSesion(correo, contrasena) {
      const { data } = await clienteApi.post('/login', { email: correo, password: contrasena })
      this.token = data.token
      this.usuario = data.user
      localStorage.setItem('token', data.token)
      localStorage.setItem('user', JSON.stringify(data.user))
    },

    async cerrarSesion() {
      await clienteApi.post('/logout')
      this.token = null
      this.usuario = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }
})
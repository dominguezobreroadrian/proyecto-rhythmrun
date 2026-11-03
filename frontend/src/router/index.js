import { createRouter, createWebHistory } from 'vue-router'
import { useAutenticacion } from '../stores/autenticacion'


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        { path: '/', component: () => import('../views/PortadaView.vue') },
        { path: '/acceso', component: () => import('../views/AccesoView.vue') },
        { path: '/registro', component: () => import('../views/RegistroView.vue') },
        { path: '/retos', component: () => import('../views/RetosView.vue'), meta: { auth: true } },
        { path: '/actividad', component: () => import('../views/ActividadView.vue'), meta: { auth: true } },
        { path: '/clasificacion', component: () => import('../views/ClasificacionView.vue'), meta: { auth: true } },
        { path: '/login', redirect: '/acceso' },
        { path: '/register', redirect: '/registro' },
        { path: '/challenges', redirect: '/retos' },
        { path: '/feed', redirect: '/actividad' },
        { path: '/ranking', redirect: '/clasificacion' },
    ],
})

// Proteger rutas privadas
router.beforeEach((to) => {
    const autenticacion = useAutenticacion()
    if (to.meta.auth && !autenticacion.estaAutenticado) {
        return '/acceso'
    }
})

export default router

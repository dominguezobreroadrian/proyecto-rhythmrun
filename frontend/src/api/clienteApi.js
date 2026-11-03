import axios from 'axios';

const clienteApi = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL || '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    }
})

// Añadir el token automáticamente en cada petición

clienteApi.interceptors.request.use(config => {
    const token = localStorage.getItem('token')
    if (token) {
        config.headers.Authorization =  `Bearer ${token}`
    }
    return config
})

export default clienteApi
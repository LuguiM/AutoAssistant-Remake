import axios from 'axios'
import { useAuthStore } from '../Stores/auth';

const authStore = useAuthStore();


axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

export const getData = async (endpoint) => {
    try {
      const response = await axios.get(`/api/${endpoint}`);
      return response.data;
    } catch (error) {
      console.error('Error al hacer la solicitud:', error);
      throw new Error('Error al obtener datos de la API');
    }
};
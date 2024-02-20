import axios from 'axios'
import { useAuthStore } from '../Stores/auth';

const authStore = useAuthStore();


axios.defaults.headers.common['Authorization'] = 'Bearer ' + authStore.authToken;

export const getData = async (endpoint) => {
  try {
    const response = await axios.get(`/api/${endpoint}`);
    return response.data;
  } catch (error) {
    if (error.response) {
      return error.response.data;
    } else if (error.request) {
      throw new Error('No se ha recibido respuesta del servidor');
    } else {
      throw new Error('Error al configurar la solicitud');
    }
  }
};

export const postData = async (endpoint, data, headers = {}) => {
  try {
    const response = await axios.post(`/api/${endpoint}`, data, { headers });
    return response.data;
  } catch (error) {
    if (error.response) {
      return error.response.data;
    } else if (error.request) {
      throw new Error('No se ha recibido respuesta del servidor');
    } else {
      throw new Error('Error al configurar la solicitud');
    }
  }
};

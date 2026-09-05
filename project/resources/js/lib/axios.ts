import axios from 'axios';
import { useAuthStore } from '../stores/AuthStore';



export const api = axios.create({
  baseURL: '/api',
  withCredentials: true, 
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

api.interceptors.response.use(
  (response) => {
    return response;
  },

  async (error) => {
    const originalRequest = error.config;

    if (error.response?.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;

      const authStore = useAuthStore();

      try {
        await authStore.refreshToken();
        return api(originalRequest);

      } catch (refreshError) {

        authStore.logout(false);
        window.location.href = '/';
        return Promise.reject(refreshError);
      }
    }

    return Promise.reject(error);
  }
);
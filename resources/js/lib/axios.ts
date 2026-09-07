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

    if (error.response?.status === 401
      && !originalRequest._retry
      && originalRequest.url !== '/auth/refresh'
    ) {
      originalRequest._retry = true;
      const authStore = useAuthStore();

      try {
        await authStore.refreshToken();
        return api(originalRequest);
      } catch (refreshError) {
        authStore.logout(false);
        return Promise.reject(refreshError);
      }
    }

    const status = error.response?.status;
    const responseData = error.response?.data;

    const customError = {
      message: responseData?.message || 'Ocorreu um erro inesperado.',
      validations: null,
      status: status,
    };

    if (status === 422) {
      customError.message = 'Por favor, corrija os campos destacados.';
      customError.validations = responseData?.errors || {};
    }

    return Promise.reject(customError);
  }
);
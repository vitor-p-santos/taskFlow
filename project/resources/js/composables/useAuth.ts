import { api } from "../lib/axios";

export const loginApi = async (email: string, password: string) => {
  const response = await api.post('/auth/login', { email, password });
  return response.data;
};

export const registerApi = async (name: string, email: string, password: string, confirmPassword: string) => {
  const response = await api.post('/users', { name, email, password, confirmPassword });
  return response.data;
};

export const logoutApi = async () => {
  const response = await api.delete('/auth/logout');
  return response.data;
};

export const meApi = async () => {
  const response = await api.get('/users/me');
  return response.data;
};

export const refreshApi = async () => {
  const response = await api.post('/auth/refresh');
  return response.data;
};
export const statisticApi = async () => {
  const response = await api.get('/users/me/statistic');
  return response.data;
};
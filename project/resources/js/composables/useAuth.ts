import { api } from "../lib/axios";
import { loginUser, registerUser } from "../types/User";

export const loginApi = async (loginData: loginUser) => {
  try {

    const response = await api.post('/auth/login', loginData);
    return response.data;
  } catch (err: any) {
    throw err
  }
};

export const registerApi = async (registerData: registerUser) => {
  try {

    const response = await api.post('/users', registerData);
    return response.data;
  } catch (err: any) {
      throw err
  }
};

export const logoutApi = async () => {
  try {

    const response = await api.delete('/auth/logout');
    return response.data;
  } catch (err: any) {
    throw err
  }
};

export const meApi = async () => {
  try {

    const response = await api.get('/users/me');
    return response.data;
  } catch (err: any) {
    throw err
  }
};

export const refreshApi = async () => {
  try {

    const response = await api.post('/auth/refresh');
    return response.data;
  } catch (err: any) {
    throw err
  }
};

export const statisticApi = async () => {
  try {

    const response = await api.get('/users/me/statistic');
    return response.data;
  } catch (err: any) {
    throw err
  }
};
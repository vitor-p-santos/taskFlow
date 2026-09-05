import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios"; // Importamos o axios para verificar o tipo do erro
import { loginApi, logoutApi, meApi, refreshApi, registerApi, statisticApi } from '../composables/useAuth';
import { User, StatisticUser, registerUser } from "../types/User";

export const useAuthStore = defineStore('auth', () => {

  const isAuthenticated = ref<boolean>(window.localStorage.getItem('is_auth') === 'true');
  const loading = ref<boolean>(false);
  const error = ref<string | null>(null);
  const user = ref<User | null>(null);
  const statistic = ref<StatisticUser | null>(null);

  async function statistics() {
    try {
      statistic.value = await statisticApi(); 
    } catch(err) {
      console.error("Erro ao buscar estatísticas:", err);
    }
  }

  async function fetchUser() {
    try {
      user.value = await meApi();
    } catch (err) {
      logout(false);
      throw err;
    }
  }

  async function refreshToken(): Promise<boolean> {
    try {
      await refreshApi();
      return true;
    } catch (err) {
      logout(false);
      return false;
    }
  }

  async function loginAuth(emailInput: string, passwordInput: string) {
    loading.value = true;
    error.value = null;

    try {
      await loginApi(emailInput, passwordInput);

      isAuthenticated.value = true;
      window.localStorage.setItem('is_auth', 'true');
      
      await fetchUser();
      return true;
    } catch (err: unknown) {
      if (axios.isAxiosError(err)) {
        error.value = err.response?.data?.message || err.message || 'Erro ao realizar login';
      } else if (err instanceof Error) {
        error.value = err.message;
      } else {
        error.value = 'Erro desconhecido ao realizar login';
      }
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function register(payload: registerUser) {
    loading.value = true;
    error.value = null;
    
    try {
      await registerApi(payload.name, payload.email, payload.password, payload.confirmPassword);
      window.localStorage.setItem('is_auth', 'true');
      return true;
    } catch (err: unknown) {
      if (axios.isAxiosError(err)) {
        error.value = err.response?.data?.message || err.message || 'Erro ao criar conta';
      } else {
        error.value = 'Erro desconhecido no registro';
      }
      console.error("Erro no registro:", err);
      return false;
    } finally {
      loading.value = false;
    }
  }

  async function logout(callApi: boolean = true) {
    try {
      if (isAuthenticated.value && callApi) {
        await logoutApi();
      }
    } catch (err) {
      console.error("Erro no logout", err);
    } finally {
      isAuthenticated.value = false;
      user.value = null;
      statistic.value = null;
      error.value = null;
      window.localStorage.removeItem('is_auth');
    }
  }

  return {
    isAuthenticated,
    loading,
    error,
    user,
    statistic,
    
    statistics,
    fetchUser,
    refreshToken,
    loginAuth,
    register,
    logout
  };
});
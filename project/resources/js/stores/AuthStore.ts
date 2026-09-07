import { defineStore } from "pinia";
import { ref } from "vue";
import { loginApi, logoutApi, meApi, refreshApi, registerApi, statisticApi } from '../composables/useAuth';
import { User, StatisticUser, registerUser, loginUser } from "../types/User";

export const useAuthStore = defineStore('auth', () => {

  const loading = ref<boolean>(false);
  const error = ref<any | null>(null);
  const user = ref<User | null>(null);
  const statistic = ref<StatisticUser | null>(null);

  //refrash do jwt  
  async function refreshToken(): Promise<boolean> {
    try {
      await refreshApi();
      return true;
    } catch (err) {
      logout(false);
      throw err;
    }
  }
  async function loginAuth(loginPayload: loginUser) {
    loading.value = true;
    error.value = null;

    try {
      await loginApi(loginPayload);
      await fetchUser();
      return true;
    } catch (err: any) {
      error.value = err;
      return false;
    } finally {
      loading.value = false;
    }
  }

  async function register(payload: registerUser) {
    loading.value = true;
    error.value = null;

    try {
      await registerApi(payload);
      
      return true;
    } catch (err: any) {
      error.value = err
      return false;
    } finally {
      loading.value = false;
    }
  }

  async function logout(callApi: boolean = true) {
    try {
      if (callApi) {
        await logoutApi();
      }
      
    } catch (err) {
      throw err
    } finally {
      user.value = null;
      statistic.value = null;
    }
  }

  async function statistics() {
    try {
      statistic.value = await statisticApi();
    } catch (err) {
      throw err
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

  return {
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
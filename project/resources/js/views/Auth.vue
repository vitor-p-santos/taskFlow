<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { storeToRefs } from 'pinia';
import { useAuthStore } from '../stores/AuthStore';
import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import type { loginUser, registerUser } from '../types/User';

const router = useRouter();
const authStore = useAuthStore();
const { error, loading } = storeToRefs(authStore); 

const isRegister = ref<boolean>(false);

const showLogin = () => {
  error.value = null; 
  isRegister.value = false;
}

const showRegister = () => {
  error.value = null; 
  isRegister.value = true;
}

const handleLogin = async (payload: loginUser) => {
  const success = await authStore.loginAuth(payload);
  if (success) {
    router.push({ name: 'projects' });
  }
};

const handleRegister = async (payload: registerUser) => {
  const success = await authStore.register(payload);
  if (success) {
    router.push({ name: 'projects' });
  }
};
</script>

<template>
  <main class="min-h-screen bg-[#121212] text-neutral-100 flex items-center justify-center p-4">
    <div class="w-full max-w-sm bg-zinc-800/90 rounded-xl p-5 shadow-2xl border border-zinc-700/60 overflow-hidden backdrop-blur-sm">

      <div class="relative flex bg-zinc-900/80 p-0.5 rounded-lg mb-5 border border-zinc-700/50 text-xs font-medium">
        <div
          class="absolute top-0.5 bottom-0.5 w-[calc(50%-2px)] bg-zinc-700/80 rounded-md transition-transform duration-200 ease-out shadow-sm"
          :class="isRegister ? 'translate-x-[calc(100%+0px)]' : 'translate-x-0'"></div>

        <button type="button"
          class="relative z-10 w-1/2 py-1.5 transition-colors duration-150 cursor-pointer text-center"
          :class="!isRegister ? 'text-zinc-100 font-semibold' : 'text-zinc-400 hover:text-zinc-200'"
          @click="showLogin">
          Login
        </button>

        <button type="button"
          class="relative z-10 w-1/2 py-1.5 transition-colors duration-150 cursor-pointer text-center"
          :class="isRegister ? 'text-zinc-100 font-semibold' : 'text-zinc-400 hover:text-zinc-200'"
          @click="showRegister">
          Criar Conta
        </button>
      </div>

      <Transition mode="out-in" enter-active-class="transition-all duration-200 ease-out"
        leave-active-class="transition-all duration-150 ease-in"
        :enter-from-class="isRegister ? 'opacity-0 translate-x-6' : 'opacity-0 -translate-x-6'"
        :leave-to-class="isRegister ? 'opacity-0 -translate-x-6' : 'opacity-0 translate-x-6'">

        <div v-if="isRegister" key="register">
          <Register :loading="loading" :error="error" @submit="handleRegister" />
        </div>

        <div v-else key="login">
          <Login :loading="loading" :error="error" @submit="handleLogin" />
        </div>

      </Transition>

    </div>
  </main>
</template>
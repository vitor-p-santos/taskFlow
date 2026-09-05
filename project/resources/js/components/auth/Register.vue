<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/AuthStore';


const AuthStore = useAuthStore();
const { loading, error } = storeToRefs(AuthStore);

const form = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
});
const router = useRouter();

const handleSubmit = async () => {
  try {
    await AuthStore.register(form);
    
    router.push({name: 'projects'});
    
  } catch (err) {
  }
};

</script>

<template>
  <form class="flex flex-col gap-3 w-full" @submit.prevent="handleSubmit">

    <div class="flex flex-col gap-1">
      <label for="name" class="text-xs font-medium text-zinc-300">Nome</label>
      <input type="text" name="name" id="name" placeholder="Digite seu nome" v-model="form.name"
        class="w-full bg-zinc-900/90 border border-zinc-700/80 rounded-lg px-3 py-1.5 text-xs text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-colors">
    </div>

    <div class="flex flex-col gap-1">
      <label for="email" class="text-xs font-medium text-zinc-300">Email</label>
      <input type="email" name="email" id="email" placeholder="seu@email.com" v-model="form.email"
        class="w-full bg-zinc-900/90 border border-zinc-700/80 rounded-lg px-3 py-1.5 text-xs text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-colors">
    </div>

    <div class="flex flex-col gap-1">
      <label for="password" class="text-xs font-medium text-zinc-300">Senha</label>
      <input type="password" name="password" id="password" placeholder="••••••••" v-model="form.password"
        class="w-full bg-zinc-900/90 border border-zinc-700/80 rounded-lg px-3 py-1.5 text-xs text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-colors">
    </div>

    <div class="flex flex-col gap-1">
      <label for="password" class="text-xs font-medium text-zinc-300">Confirmar Senha</label>
      <input type="password" name="password" id="password" placeholder="••••••••" v-model="form.confirmPassword"
        class="w-full bg-zinc-900/90 border border-zinc-700/80 rounded-lg px-3 py-1.5 text-xs text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-colors">
    </div>

    <button type="submit"
      class="w-full mt-1.5 bg-zinc-100 hover:bg-white text-zinc-900 font-semibold py-2 px-3 text-xs rounded-lg transition duration-150 active:scale-[0.98] cursor-pointer shadow-sm">
      Cadastrar
    </button>
  </form>
</template>
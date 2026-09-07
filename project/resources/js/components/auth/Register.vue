<script setup lang="ts">
import { reactive, ref } from 'vue';
import type { registerUser } from '../../types/User';
import { Eye, EyeOff } from 'lucide-vue-next';

defineProps<{
  loading: boolean;
  error: any;
}>();

const emit = defineEmits<{
  (e: 'submit', payload: registerUser): void;
}>();

const form = reactive<registerUser>({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const handleSubmit = () => {
  emit('submit', { ...form });
};
</script>

<template>
  <form class="flex flex-col gap-3 w-full" @submit.prevent="handleSubmit">
    
    <div v-if="error?.message" class="text-xs text-center text-red-400 bg-red-950/50 border border-red-800/50 rounded-lg px-3 py-2">
      {{ error.message }}
    </div>

    <div class="flex flex-col gap-1">
      <label for="name" class="text-xs font-medium text-zinc-300">Nome</label>
      <input type="text" name="name" id="name" placeholder="Digite seu nome" v-model="form.name" required
        class="w-full bg-zinc-900/90 border border-zinc-700/80 rounded-lg px-3 py-1.5 text-xs text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-colors">
        
      <span v-if="error?.validations?.name" class="text-red-400 text-xs">
        {{ error.validations.name[0] }}
      </span>
    </div>

    <div class="flex flex-col gap-1">
      <label for="email" class="text-xs font-medium text-zinc-300">Email</label>
      <input type="email" name="email" id="email" placeholder="seu@email.com" v-model="form.email" required 
        class="w-full bg-zinc-900/90 border border-zinc-700/80 rounded-lg px-3 py-1.5 text-xs text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-colors">
      <span v-if="error?.validations?.email" class="text-red-400 text-xs">
        {{ error.validations.email[0] }}
      </span>
    </div>

    <!-- Senha com ícone -->
    <div class="flex flex-col gap-1">
      <label for="register-password" class="text-xs font-medium text-zinc-300">Senha</label>
      <div class="relative w-full">
        <input :type="showPassword ? 'text' : 'password'" name="password" id="register-password" placeholder="••••••••" v-model="form.password" required
          class="w-full bg-zinc-900/90 border border-zinc-700/80 rounded-lg px-3 py-1.5 pr-8 text-xs text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-colors">
        <button type="button" @click="showPassword = !showPassword"
          class="absolute right-2.5 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-200 cursor-pointer">
          <component :is="showPassword ? EyeOff : Eye" class="w-4 h-4" />
        </button>
      </div>
      <span v-if="error?.validations?.password" class="text-red-400 text-xs">
        {{ error.validations.password[0] }}
      </span>
    </div>

    <!-- Confirmar Senha com ícone -->
    <div class="flex flex-col gap-1">
      <label for="confirmPassword" class="text-xs font-medium text-zinc-300">Confirmar Senha</label>
      <div class="relative w-full">
        <input :type="showConfirmPassword ? 'text' : 'password'" name="confirmPassword" id="confirmPassword" placeholder="••••••••" v-model="form.confirmPassword" required
          class="w-full bg-zinc-900/90 border border-zinc-700/80 rounded-lg px-3 py-1.5 pr-8 text-xs text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-colors">
        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
          class="absolute right-2.5 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-200 cursor-pointer">
          <component :is="showConfirmPassword ? EyeOff : Eye" class="w-4 h-4" />
        </button>
      </div>
      <span v-if="error?.validations?.confirmPassword" class="text-red-400 text-xs">
        {{ error.validations.confirmPassword[0] }}
      </span>
    </div>

    <button type="submit" :disabled="loading"
      class="w-full mt-1.5 bg-zinc-100 hover:bg-white text-zinc-900 font-semibold py-2 px-3 text-xs rounded-lg transition duration-150 active:scale-[0.98] cursor-pointer shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
      {{ loading ? 'Criando Usuário...' : 'Criar Conta' }}
    </button>
  </form>
</template>
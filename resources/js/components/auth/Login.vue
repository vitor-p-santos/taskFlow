<script setup lang="ts">
import { reactive, ref } from 'vue';
import type { loginUser } from '../../types/User';
import { Eye, EyeOff } from 'lucide-vue-next';

defineProps<{
  loading: boolean;
  error: any;
}>();

const emit = defineEmits<{
  (e: 'submit', payload: loginUser): void;
}>();

const form = reactive<loginUser>({
  email: '',
  password: ''
});

const showPassword = ref(false);

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
      <label for="email" class="text-xs font-medium text-zinc-300">Email</label>
      <input type="email" name="email" id="email" placeholder="seu@email.com" v-model="form.email" required
        class="w-full bg-zinc-900/90 border border-zinc-700/80 rounded-lg px-3 py-1.5 text-xs text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-zinc-400 focus:ring-1 focus:ring-zinc-400 transition-colors">
      <span v-if="error?.validations?.email" class="text-red-400 text-xs">
        {{ error.validations.email[0] }}
      </span>
    </div>

    <div class="flex flex-col gap-1">
      <label for="password" class="text-xs font-medium text-zinc-300">Senha</label>
      <div class="relative w-full">
        <input :type="showPassword ? 'text' : 'password'" name="password" id="password" placeholder="••••••••" v-model="form.password" required
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

    <button type="submit" :disabled="loading"
      class="w-full mt-1.5 bg-zinc-100 hover:bg-white text-zinc-900 font-semibold py-2 px-3 text-xs rounded-lg transition duration-150 active:scale-[0.98] cursor-pointer shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
      {{ loading ? 'Entrando...' : 'Entrar' }}
    </button>
  </form>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import Loading from './Loading.vue'

defineProps<{
  isOpen: boolean
  loading?: boolean
  error?:any
}>()

const emit = defineEmits(['close', 'submit'])

const name = ref('')
const status = ref('active')
const description = ref('')

const handleFormSubmit = () => {

  emit('submit', {
    name: name.value,
    status: status.value,
    description: description.value
  })

}

const close = () => {
  emit('close')
}
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-xs transition-opacity" @click="!loading && close()"></div>

    <div class="relative z-10 w-full max-w-md rounded-2xl bg-neutral-900 p-6 shadow-2xl border border-neutral-800 flex flex-col gap-6">
      
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-lg font-semibold text-white tracking-wide">Novo projeto</h3>
          <p class="text-xs text-neutral-400 mt-0.5">Preencha os dados abaixo para criar um novo projeto.</p>
        </div>
        <button 
          @click="close" 
          :disabled="loading"
          class="w-8 h-8 flex items-center justify-center rounded-lg text-neutral-400 hover:text-white hover:bg-neutral-800 transition-colors disabled:opacity-50"
        >
          ✕
        </button>
      </div>

      <div v-if="loading" class="py-6">
        <Loading size="md" message="Criando projeto..." />
      </div>

      <form v-else class="flex flex-col gap-4" @submit.prevent="handleFormSubmit">
        <div class="flex flex-col gap-1.5">
          <label for="name" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Nome</label>
          <input 
            v-model="name"
            required 
            id="name" 
            placeholder="Ex: Dashboard Financeiro"
            class="text-white bg-neutral-800/80 border border-neutral-700/80 rounded-xl px-3.5 py-2.5 text-sm placeholder:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all" 
          />
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="status" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Status</label>
          <select 
            v-model="status"
            required 
            id="status"
            class="text-white bg-neutral-800/80 border border-neutral-700/80 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all cursor-pointer"
          >
            <option value="active" class="bg-neutral-900 text-white">Ativo</option>
            <option value="archived" class="bg-neutral-900 text-white">Arquivado</option>
          </select>
        </div>

        <div class="flex flex-col gap-1.5">
          <label for="description" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Descrição</label>
          <textarea 
            v-model="description"
            required 
            id="description" 
            placeholder="Breve resumo sobre o objetivo do projeto..."
            rows="3"
            class="text-white bg-neutral-800/80 border border-neutral-700/80 rounded-xl px-3.5 py-2.5 text-sm placeholder:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all resize-none"
          ></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
          <button 
            type="button"
            @click="close"
            class="px-4 py-2.5 text-sm font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 hover:text-white transition-colors"
          >
            Cancelar
          </button>
          <button 
            type="submit" 
            class="px-5 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-950/50 active:scale-95"
          >
            Criar projeto
          </button>
        </div>
      </form>

    </div>
  </div>
</template>
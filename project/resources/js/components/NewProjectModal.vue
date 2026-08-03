<script setup lang="ts">
import { ref, watch } from 'vue'
import BaseModal from '../layouts/Modal.vue'

const props = defineProps<{
  isOpen: boolean
  loading?: boolean
  error?: any
}>()

const name = ref('')
const status = ref('active')
const description = ref('')

const resetForm = () => {
  name.value = ''
  status.value = 'active'
  description.value = ''
}

watch(() => props.isOpen, (newValue) => {
  if (!newValue) {
    resetForm()
  }
})


const emit = defineEmits(['submit', 'close'])

const handleFormSubmit = () => {
  emit('submit', {
    name: name.value,
    status: status.value,
    description: description.value
  })
}
</script>

<template>
  <BaseModal :is-open="isOpen" :loading="loading" title="Novo projeto"
    description="Preencha os dados abaixo para criar um novo projeto." @close="$emit('close')">
    <form class="flex flex-col gap-4" @submit.prevent="handleFormSubmit">

      <div v-if="error" class="bg-red-950/40 border border-red-900/50 text-red-300 px-3 py-2.5 rounded-xl text-xs text-center">
        <span>
          Erro ao novo criar projeto!
        </span>
      </div>

      <div class="flex flex-col gap-1.5">
        <label for="name" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Nome</label>
        <input v-model="name" required id="name" placeholder="Ex: Dashboard Financeiro"
          class="text-white bg-neutral-800/80 border rounded-xl px-3.5 py-2.5 text-sm placeholder:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all"
          :class="error?.name ? 'border-red-500' : 'border-neutral-700/80'" />

        <span v-if="error?.name" class="text-red-400 text-xs">
          {{ error.name[0] }}
        </span>
      </div>

      <div class="flex flex-col gap-1.5">
        <label for="status" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Status</label>
        <select v-model="status" required id="status"
          class="text-white bg-neutral-800/80 border rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all cursor-pointer"
          :class="error?.status ? 'border-red-500' : 'border-neutral-700/80'">
          <option value="active" class="bg-neutral-900 text-white">Ativo</option>
          <option value="archived" class="bg-neutral-900 text-white">Arquivado</option>
        </select>

        <span v-if="error?.status" class="text-red-400 text-xs">
          {{ error.status[0] }}
        </span>
      </div>

      <div class="flex flex-col gap-1.5">
        <label for="description"
          class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Descrição</label>
        <textarea v-model="description" required id="description"
          placeholder="Breve resumo sobre o objetivo do projeto..." rows="3"
          class="text-white bg-neutral-800/80 border rounded-xl px-3.5 py-2.5 text-sm placeholder:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all resize-none"
          :class="error?.description ? 'border-red-500' : 'border-neutral-700/80'"></textarea>

        <span v-if="error?.description" class="text-red-400 text-xs">
          {{ error.description[0] }}
        </span>
      </div>

      <div class="flex items-center justify-end gap-3 pt-2">
        <button type="button" @click="$emit('close')"
          class="px-4 py-2.5 text-sm font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 hover:text-white transition-colors">
          Cancelar
        </button>
        <button type="submit" :disabled="loading"
          class="px-5 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-950/50 active:scale-95 disabled:opacity-50">
          {{ loading ? 'Criando...' : 'Criar tarefa' }}
        </button>
      </div>
    </form>
  </BaseModal>
</template>
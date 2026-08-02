<script setup lang="ts">
import { ref, watch } from 'vue'
import BaseModal from '../layouts/Modal.vue'

const props = defineProps<{
  isOpen: boolean
  loading?: boolean
  error?: any
}>()

const title = ref('')
const status = ref('todo')
const priority = ref('low')
const due_date = ref('')
const description = ref('')

const emit = defineEmits(['submit', 'close'])

const resetForm = () => {
  title.value = ''
  status.value = 'todo'
  priority.value = 'low'
  due_date.value = ''
  description.value = ''
}

watch(() => props.isOpen, (newValue) => {
  if (!newValue) {
    resetForm()
  }
})

const handleFormSubmit = () => {
  emit('submit', {
    title: title.value,
    status: status.value,
    priority: priority.value,
    description: description.value,
    due_date: due_date.value,
  })
}
</script>

<template>
  <BaseModal :is-open="isOpen" :loading="loading" title="Nova Tarefa"
    description="Preencha os dados abaixo para criar uma nova tarefa." @close="$emit('close')">
    <form class="flex flex-col gap-4" @submit.prevent="handleFormSubmit">
      
      <div v-if="error && !error?.errors"
        class="bg-red-950/40 border border-red-900/50 text-red-300 px-3 py-2.5 rounded-xl text-xs text-center">
        <span>Erro ao criar tarefa!</span>
      </div>


      <div class="flex flex-col gap-1.5">
        <label for="title" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Nome</label>
        <input v-model="title" required id="title" placeholder="Ex: Dashboard Financeiro"
          class="text-white bg-neutral-800/80 border rounded-xl px-3.5 py-2.5 text-sm placeholder:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all"
          :class="error?.title ? 'border-red-500' : 'border-neutral-700/80'" />
        <span v-if="error?.title" class="text-red-400 text-xs">
          {{ Array.isArray(error.title) ? error.title[0] : error.title }}
        </span>
      </div>

      <!-- Status e Prioridade -->
      <div class="flex flex-row gap-4 w-full">
        <div class="flex flex-col gap-1.5 flex-1">
          <label for="status" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Status</label>
          <select v-model="status" required id="status" class="w-full text-white bg-neutral-800/80 border rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all cursor-pointer"
            :class="error?.status ? 'border-red-500' : 'border-neutral-700/80'">
            <option value="todo" class="bg-neutral-900 text-white">Pendente</option>
            <option value="in_progress" class="bg-neutral-900 text-white">Em progresso</option>
            <option value="done" class="bg-neutral-900 text-white">Concluído</option>
          </select>
          <span v-if="error?.status" class="text-red-400 text-xs">
            {{ Array.isArray(error.status) ? error.status[0] : error.status }}
          </span>
        </div>

        <div class="flex flex-col gap-1.5 flex-1">
          <label for="priority" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Prioridade</label>
          <select v-model="priority" required id="priority"
            class="w-full text-white bg-neutral-800/80 border rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all cursor-pointer"
            :class="error?.priority ? 'border-red-500' : 'border-neutral-700/80'">
            <option value="low" class="bg-neutral-900 text-white">Baixa</option>
            <option value="medium" class="bg-neutral-900 text-white">Média</option>
            <option value="high" class="bg-neutral-900 text-white">Alta</option>
          </select>
          <span v-if="error?.priority" class="text-red-400 text-xs">
            {{ Array.isArray(error.priority) ? error.priority[0] : error.priority }}
          </span>
        </div>
      </div>

      <!-- Descrição -->
      <div class="flex flex-col gap-1.5">
        <label for="description" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Descrição</label>
        <textarea v-model="description" required id="description"
          placeholder="Breve resumo sobre o objetivo do projeto..." rows="3"
          class="text-white bg-neutral-800/80 border rounded-xl px-3.5 py-2.5 text-sm placeholder:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all resize-none"
          :class="error?.description ? 'border-red-500' : 'border-neutral-700/80'"></textarea>
        <span v-if="error?.description" class="text-red-400 text-xs">
          {{ Array.isArray(error.description) ? error.description[0] : error.description }}
        </span>
      </div>

      <!--  -->
      <div class="flex flex-col gap-1.5">
        <label for="due_date" class="text-xs font-semibold uppercase tracking-wider text-neutral-300">Vencimento</label>
        <input v-model="due_date" required id="due_date" type="date"
          class="text-white bg-neutral-800/80 border rounded-xl px-3.5 py-2.5 text-sm placeholder:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/80 transition-all"
          :class="error?.due_date ? 'border-red-500' : 'border-neutral-700/80'">
        <span v-if="error?.due_date" class="text-red-400 text-xs">
          {{ Array.isArray(error.due_date) ? error.due_date[0] : error.due_date }}
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
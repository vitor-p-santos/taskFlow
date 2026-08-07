<script setup lang="ts">
import { computed } from 'vue'
import FilterBase from '../../layouts/Filter.vue'
import { X } from 'lucide-vue-next'

const searchInput = defineModel<string>('searchInput', { default: '' })
const statusSelect = defineModel<string>('statusSelect', { default: '' })

const hasFilters = computed(() => searchInput.value !== '' || statusSelect.value !== '')

function clearFilters() {
  searchInput.value = ''
  statusSelect.value = ''
}
</script>

<template>
  <FilterBase>
    <div class="flex flex-row justify-between items-center w-full">
      <div class="flex sm:flex-row sm:items-center gap-2 sm:gap-3">
        <label for="search" class="text-sm font-medium text-neutral-300">
          Projeto
        </label>
        <input
          id="search"
          v-model="searchInput"
          type="text"
          placeholder="Nome do projeto..."
          class="w-full sm:w-72 text-sm text-neutral-100 rounded-xl bg-neutral-950 border-b border-neutral-800 px-2 py-1 placeholder:text-neutral-500 focus:border-neutral-500 focus:outline-none transition-colors"
        />

        <label for="status" class="text-sm font-medium text-neutral-300">
          Status
        </label>
        <select
          id="status"
          v-model="statusSelect"
          class="w-full sm:w-36 px-3 py-2 sm:py-1.5 rounded-xl bg-neutral-950 border border-neutral-800 text-neutral-200 text-xs focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-colors cursor-pointer"
        >
          <option value="">Todos</option>
          <option value="active">Ativo</option>
          <option value="archived">Arquivado</option>
        </select>
      </div>

      <button
        v-if="hasFilters"
        @click="clearFilters"
        type="button"
        class="inline-flex items-center gap-1 text-sm text-red-400 hover:text-red-300 transition-colors"
      >
        <X class="w-4 h-4" />
        <span>Limpar filtro</span>
      </button>
    </div>
  </FilterBase>
</template>
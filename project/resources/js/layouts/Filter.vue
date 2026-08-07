<script setup lang="ts">

const props = defineProps<{
  status: string,
  priority: string,
  dueDate: boolean
}>()

defineEmits<{
  (e: 'update:status', value: string): void
  (e: 'update:priority', value: string): void
  (e: 'update:dueDate', value: boolean): void
  (e: 'clearFilter'): void
}>()


</script>

<template>
  
  <nav class="max-w-7xl mx-auto px-4 my-4 sm:my-6">
    <div
      class="bg-neutral-900 border border-neutral-800/80 rounded-2xl p-4 sm:p-5 shadow-xl flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">

      <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 w-full lg:w-auto">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full sm:w-auto">
          <div class="flex items-center gap-2">
            <label for="status-filter"
              class="text-xs font-medium text-neutral-400 shrink-0 w-16 sm:w-auto">Status:</label>
            <select id="status-filter" :value="status"
              @change="$emit('update:status', ($event.target as HTMLSelectElement).value)"
              class="w-full sm:w-36 px-3 py-2 sm:py-1.5 rounded-xl bg-neutral-950 border border-neutral-800 text-neutral-200 text-xs focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-colors cursor-pointer">
              <option value="">Todos</option>
              <option value="todo">Pendente</option>
              <option value="in_progress">Em progresso</option>
              <option value="done">Concluído</option>
            </select>
          </div>

          <div class="flex items-center gap-2">
            <label for="priority-filter"
              class="text-xs font-medium text-neutral-400 shrink-0 w-16 sm:w-auto">Prioridade:</label>
            <select id="priority-filter" :value="priority"
              @change="$emit('update:priority', ($event.target as HTMLSelectElement).value)"
              class="w-full sm:w-36 px-3 py-2 sm:py-1.5 rounded-xl bg-neutral-950 border border-neutral-800 text-neutral-200 text-xs focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-colors cursor-pointer">
              <option value="">Todas</option>
              <option value="low">Baixa</option>
              <option value="medium">Média</option>
              <option value="high">Alta</option>
            </select>
          </div>
        </div>

        <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
          <div v-if="props.dueDate || props.priority || props.status" class="w-full sm:w-auto">
            <button @click="$emit('clearFilter')"
              class="w-full sm:w-auto px-3 py-2 sm:py-1.5 rounded-xl bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs hover:text-white hover:border-neutral-700 active:scale-[0.98] focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-all cursor-pointer">
              Limpar filtro
            </button>
          </div>
        </Transition>
      </div>

      <div class="flex items-center gap-2.5 pt-2 lg:pt-0 border-t border-neutral-800/60 lg:border-t-0">
        <input id="hide-completed" type="checkbox" :checked="dueDate"
          @change="$emit('update:dueDate', ($event.target as HTMLInputElement).checked)"
          class="appearance-none w-4 h-4 rounded bg-neutral-950 border border-neutral-800 checked:bg-emerald-500 checked:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500/20 cursor-pointer transition-colors relative flex items-center justify-center checked:after:content-['✓'] checked:after:text-neutral-950 checked:after:text-[10px] checked:after:font-bold">
        <label for="hide-completed" class="text-xs font-medium text-neutral-300 cursor-pointer select-none">
          Apenas em atraso
        </label>
      </div>

    </div>
  </nav>
</template>
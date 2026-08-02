<script setup lang="ts">
// Definimos as props e os emits para atualizar via v-model
defineProps<{ 
  status: string, 
  priority: string, 
  dueDate: boolean 
}>()

defineEmits<{
  (e: 'update:status', value: string): void
  (e: 'update:priority', value: string): void
  (e: 'update:dueDate', value: boolean): void
}>()

</script>

<template>
  <div class="max-w-7xl mx-auto px-4 my-6">
    <div class="bg-neutral-900 border border-neutral-800/80 rounded-2xl p-4 sm:p-5 shadow-xl flex flex-wrap items-center justify-between gap-4">

      <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
        <!-- Status Filter -->
        <div class="flex items-center gap-2">
          <label for="status-filter" class="text-xs font-medium text-neutral-400 shrink-0">Status:</label>
          <select 
            id="status-filter" 
            :value="status"
            @change="$emit('update:status', ($event.target as HTMLSelectElement).value)"
            class="w-32 sm:w-36 px-2.5 py-1.5 rounded-xl bg-neutral-950 border border-neutral-800 text-neutral-200 text-xs focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-colors cursor-pointer"
          >
            <option value="">Todos</option>
            <option value="todo">Pendente</option>
            <option value="in_progress">Em progresso</option>
            <option value="done">Concluído</option>
          </select>

          
        </div>

        <!-- Priority Filter -->
        <div class="flex items-center gap-2">
          <label for="priority-filter" class="text-xs font-medium text-neutral-400 shrink-0">Prioridade:</label>
          <select 
            id="priority-filter" 
            :value="priority"
            @change="$emit('update:priority', ($event.target as HTMLSelectElement).value)"
            class="w-32 sm:w-36 px-2.5 py-1.5 rounded-xl bg-neutral-950 border border-neutral-800 text-neutral-200 text-xs focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-colors cursor-pointer"
          >
            <option value="">Todas</option>
            <option value="low">Baixa</option>
            <option value="medium">Média</option>
            <option value="high">Alta</option>
          </select>
        </div>
      </div>

      <!-- Due Date Checkbox -->
      <div class="flex items-center gap-2.5">
        <input 
          id="hide-completed" 
          type="checkbox" 
          :checked="dueDate"
          @change="$emit('update:dueDate', ($event.target as HTMLInputElement).checked)"
          class="appearance-none w-4 h-4 rounded bg-neutral-950 border border-neutral-800 checked:bg-emerald-500 checked:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500/20 cursor-pointer transition-colors relative flex items-center justify-center checked:after:content-['✓'] checked:after:text-neutral-950 checked:after:text-[10px] checked:after:font-bold"
        >
        <label for="hide-completed" class="text-xs font-medium text-neutral-300 cursor-pointer select-none">
          Apenas em atraso
        </label>
      </div>

    </div>
  </div>
</template>
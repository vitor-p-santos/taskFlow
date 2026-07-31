<script setup lang="ts">
import { onMounted, ref } from 'vue'
import Loading from '../components/Loading.vue'
import { useTask } from '../composables/useTask.ts'
import { useRoute } from 'vue-router'

const { tasks, loading, error, fetchTask } = useTask()
const isOpen = ref(false)
const route = useRoute()

const id = route.params.id

onMounted(() => {
  fetchTask(Number(id))
})

const getOverDue = (date: string): string => {
  if (!date) return 'text-neutral-500';
  
  const [day, month, year] = date.split('/');
  const isoDateString = `${year}-${month}-${day}`;

  const targetDate = new Date(isoDateString).getTime();
  const now = new Date().getTime();

  return targetDate < now ? 'text-red-400' : 'text-emerald-400';
};
</script>

<template>
  <div class="min-h-screen bg-[#121212] text-neutral-100">
    <header class="border-b border-neutral-800 bg-neutral-900/50 backdrop-blur-md sticky top-0 z-40">
      <div class="max-w-7xl mx-auto py-6 px-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Tarefas do Projeto</h1>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
      <div v-if="loading">
        <Loading message="Buscando tarefas..." size="lg" full-screen />
      </div>

      <div v-else-if="error"
        class="bg-red-950/40 border border-red-900/50 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
        {{ error }}
      </div>

      <div v-else-if="tasks.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="task in tasks" 
          :key="task.id"
          class="group relative flex flex-col justify-between rounded-2xl bg-neutral-900 p-6 shadow-xl border border-neutral-800/80 transition-all duration-300 hover:-translate-y-1 hover:border-neutral-700"
        >
          <div>
            <div class="flex items-start justify-between gap-4 mb-3">
              <h3 class="text-base font-semibold tracking-tight text-white line-clamp-1">
                {{ task.title }}
              </h3>

              <!-- Agrupamento dos selects de status e prioridade -->
              <div class="flex items-center gap-2 shrink-0">
                <select v-model="task.status"
                  class="px-2.5 py-1 rounded-full text-xs font-medium border bg-neutral-900 text-neutral-200 border-neutral-700 focus:outline-none focus:ring-1 focus:ring-emerald-500 cursor-pointer transition-colors">
                  <option value="todo" class="bg-neutral-900 text-neutral-300">Pendente</option>
                  <option value="in_progress" class="bg-neutral-900 text-amber-400">Em progresso</option>
                  <option value="done" class="bg-neutral-900 text-emerald-400">Concluído</option>
                </select>

                <select v-model="task.priority"
                  class="px-2.5 py-1 rounded-full text-xs font-medium border bg-neutral-900 text-neutral-200 border-neutral-700 focus:outline-none focus:ring-1 focus:ring-neutral-500 cursor-pointer transition-colors">
                  <option value="low" class="bg-neutral-900 text-neutral-200">Baixa</option>
                  <option value="medium" class="bg-neutral-900 text-neutral-200">Média</option>
                  <option value="high" class="bg-neutral-900 text-neutral-200">Alta</option>
                </select>
              </div>
            </div>

            <p class="text-sm font-normal text-neutral-400 line-clamp-2 mb-6 leading-relaxed">
              {{ task.description }}
            </p>
          </div>

          <div class="pt-4 border-t border-neutral-800/80 flex items-center justify-between text-xs">
            <span class="text-neutral-500">Criado em {{ task.created_at }}</span>
            <span :class="getOverDue(task.due_date)" class="font-medium">
              Vencimento: {{ task.due_date }}
            </span>
          </div>
        </div>
      </div>

      <div v-else class="text-center text-neutral-500 py-24 border border-dashed border-neutral-800 rounded-2xl">
        Nenhuma tarefa encontrada.
      </div>
    </main>
  </div>
</template>
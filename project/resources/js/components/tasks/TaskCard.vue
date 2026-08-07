<script setup lang="ts">
import { Trash2 } from 'lucide-vue-next'
import Card from '../../layouts/Card.vue';
import { Task } from '../../types/Task';
import Loading from '../Loading.vue';

const props = defineProps<{ task: Task, loading: boolean, patchLoading: boolean }>();


const emit = defineEmits<{
  (e: 'delete', id: number): void
  (e: 'patch', payload: { taskId: number; patchData: { status?: string; priority?: string } }): void
}>();

const handlePatch = (field: 'status' | 'priority', event: Event) => {
  const target = event.target as HTMLSelectElement;
  const value = target.value;


  emit('patch', {
    taskId: props.task.id!,
    patchData: {
      [field]: value
    }
  });
};

const getOverDue = (date: string): string => {
  if (!date) return 'text-neutral-500';
  const [day, month, year] = date.split('/');
  const targetDate = new Date(`${year}-${month}-${day}`).getTime();
  const now = new Date().getTime();
  return targetDate < now ? 'text-red-400 animate-pulse' : 'text-emerald-400';
};

</script>

<template>
  <Card>
    <div v-if="loading">
      <Loading message="Deletando..." size="sm" />
    </div>

    <div v-else>
      <div>

        <div class="flex items-start justify-between gap-4 mb-3">


          <h3 class="text-base font-semibold tracking-tight text-white line-clamp-1">
            {{ task.title }}
          </h3>

          <div v-if="patchLoading">
            <Loading inline message="Alterando" size="2sm" />
          </div>
          <div v-else>
            <button @click="emit('delete', task.id!)"><Trash2 class="w-5 h-5 text-red-400 cursor-pointer"/></button>
          </div>
        </div>

        <div class="mt-6 space-y-3">
          <div class="flex items-center justify-between">
            <label for="status" class="text-xs uppercase tracking-wider text-neutral-500">
              Status
            </label>
            <select id="stattus" :disabled="patchLoading" :value="task.status" @change="handlePatch('status', $event)"
              :class="[
                'px-2.5 py-1 rounded-full text-xs bg-neutral-900 font-semibold border transition-all focus:outline-none',
                task.status === 'todo'
                  ? 'text-neutral-200 border-neutral-700  focus:ring-neutral-500'
                  : '',
                task.status === 'in_progress'
                  ? 'bg-yellow-950/40 text-yellow-300 border-yellow-800 focus:ring-yellow-600'
                  : '',
                task.status === 'done'
                  ? 'bg-emerald-950/40 text-emerald-300 border-emerald-800 focus:ring-emerald-600'
                  : '',
                patchLoading && 'opacity-60 cursor-wait'
              ]">
              <option value="todo" class="bg-neutral-900 text-neutral-300">Pendente</option>
              <option value="in_progress" class="bg-neutral-900 text-amber-400">Em progresso</option>
              <option value="done" class="bg-neutral-900 text-emerald-400">Concluído</option>
            </select>
          </div>

          <div class="flex items-center justify-between">
            <label for="priority" class="text-xs uppercase tracking-wider text-neutral-500">
              Prioridade
            </label>
            <select id="priority" :disabled="patchLoading" :value="task.priority"
              @change="handlePatch('priority', $event)" :class="[
                'px-2.5 py-1 rounded-full text-xs bg-neutral-900 font-semibold border transition-all focus:outline-none',
                task.priority === 'low'
                  ? 'text-neutral-200 border-neutral-700  focus:ring-neutral-500'
                  : '',
                task.priority === 'medium'
                  ? 'bg-yellow-950/40 text-yellow-300 border-yellow-800 focus:ring-yellow-600'
                  : '',
                task.priority === 'high'
                  ? 'bg-red-950/40 text-red-300 border-neutral-700  focus:ring-neutral-500'
                  : '',
                patchLoading && 'opacity-60 cursor-wait'
              ]">
              <option value="low" class="bg-neutral-900 text-neutral-200">Baixa</option>
              <option value="medium" class="bg-neutral-900 text-amber-400"">Média</option>
            <option value="high" class="bg-neutral-900 text-red-300">Alta</option>

            </select>
          </div>

        </div>

        <div
          class="overflow-hidden max-h-20 hover:max-h-60 transition-all duration-500 ease-in-out mb-1 py-2">
          <p class="mb-2 py-2 text-xs uppercase tracking-wider text-center text-neutral-500 border-b border-neutral-800">
            Descrição
          </p>
          <p class="text-sm text-neutral-400 leading-relaxed">
            {{ task.description }}
          </p>
        </div>

      </div>

      <div class="pt-4 border-t border-neutral-800/80 flex items-center justify-between text-xs">
        <span class="text-neutral-500">Criado em {{ task.created_at }}</span>
        <span :class="getOverDue(task.due_date)" class="font-medium">
          Vencimento: {{ task.due_date }}
        </span>
      </div>
    </div>
  </Card>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'

interface Props {
  id: number;
  title: string;
  description: string;
  createdAt: string;
  status: string;
  taskCount: number;
}

const props = defineProps<Props>();
const router = useRouter();

// 2. Função para navegar ao clicar no card
const handleCardClick = () => {
  router.push(`/projects/${props.id}/tasks`);
};

const getStatusClass = (status: string) => {
  const s = status.toLowerCase();
  if (s.includes('active')) {
    return 'bg-emerald-950/60 text-emerald-400 border-emerald-800/60';
  } else {
    return 'bg-amber-950/60 text-amber-400 border-amber-800/60';
  }
};
</script>

<template>
  <!-- 3. Adicionado @click e cursor-pointer -->
  <div 
    @click="handleCardClick"
    class="group relative flex flex-col justify-between rounded-2xl bg-neutral-900 p-6 shadow-xl border border-neutral-800/80 transition-all duration-300 hover:-translate-y-1 hover:border-neutral-700 cursor-pointer"
  >
    <div>
      <div class="flex items-start justify-between gap-4 mb-3">
        <h3 class="text-base font-semibold tracking-tight text-white line-clamp-1">
          {{ title }}
        </h3>

        <span :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border shrink-0', getStatusClass(status)]">
          {{ status }}
        </span>
      </div>

      <p class="text-sm font-normal text-neutral-400 line-clamp-2 mb-6 leading-relaxed">
        {{ description }}
      </p>
    </div>

    <div class="pt-4 border-t border-neutral-800/80 flex items-center justify-between text-xs text-neutral-400">
      <span class="text-neutral-500">Criado em {{ createdAt }}</span>

      <div class="flex items-center gap-1.5 font-medium text-neutral-300 bg-neutral-800/80 border border-neutral-700/50 px-2.5 py-1 rounded-lg">
        <span>{{ taskCount }} {{ taskCount === 1 ? 'tarefa' : 'tarefas' }}</span>
      </div>
    </div>
  </div>
</template>
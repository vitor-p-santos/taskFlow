<script setup lang="ts">
import { useRouter } from 'vue-router'
import { Project } from '../types/projectType';
import Card from '../layouts/Card.vue'

const props = defineProps<{
  project: Project
}>();

const router = useRouter();

const handleCardClick = () => {
  router.push(`/projects/${props.project.id}/tasks`);
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
  <Card @click="handleCardClick" class="cursor-pointer">
    <div class="relative inline-block group">

      <div
        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block z-50 whitespace-nowrap px-2.5 py-1 text-xs text-neutral-100 bg-neutral-900 border border-neutral-800 rounded shadow-md pointer-events-none">
        {{ project.tasks_count > 0 ? 'clique e veja suas tarefas!' : 'Clique para crie tarefas!' }}
      </div>
    </div>
    <div>
      <div class="flex items-start justify-between gap-4 mb-3">
        <h3 class="text-base font-semibold tracking-tight text-white line-clamp-1">
          {{ project.name }}
        </h3>

        <span
          :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border shrink-0', getStatusClass(project.status)]">
          {{ project.status }}
        </span>
      </div>

      <p class="text-sm font-normal text-neutral-400 line-clamp-2 mb-6 leading-relaxed">
        {{ project.description }}
      </p>


      <div class="pt-4 border-t border-neutral-800/80 flex items-center justify-between text-xs text-neutral-400">
        <span class="text-neutral-500">Criado em {{ project.created_at }}</span>

        <div
          class="flex items-center gap-1.5 font-medium text-neutral-300 bg-neutral-800/80 border border-neutral-700/50 px-2.5 py-1 rounded-lg">
          <span>{{ project.tasks_count }} {{ project.tasks_count === 1 ? 'tarefa' : 'tarefas' }}</span>
        </div>
      </div>
    </div>
  </Card>
</template>
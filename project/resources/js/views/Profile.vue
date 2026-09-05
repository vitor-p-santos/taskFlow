<script setup lang="ts">
import MainLayout from '../layouts/MainLayout.vue'
import NavBar from '../layouts/NavBar.vue'
import { onMounted, reactive } from 'vue';
import { useAuthStore } from '../stores/AuthStore.ts';
import { storeToRefs } from 'pinia';

const authStore = useAuthStore();
const { statistic, loading } = storeToRefs(authStore);

onMounted(async () => {
  await authStore.statistics();
});

function formatDate(date?: string): string {
  if (!date) return 'Data não disponível';

  const data = new Date(date);
  const dia = String(data.getDate()).padStart(2, '0');
  const mes = String(data.getMonth() + 1).padStart(2, '0');
  const ano = data.getFullYear();

  return `${dia}/${mes}/${ano}`;
}


</script>

<template>
  <MainLayout>
    <template #header>
      <NavBar title="Perfil" />
    </template>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <section class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5 sm:p-6 space-y-4">
          <div v-if="loading">

          </div>
          <div v-else>

            <h3 class="text-base sm:text-lg font-semibold text-zinc-100 border-b border-zinc-800 pb-3">
              Contagem de projetos e tarefas
            </h3>
            <div>
              <h5 class="text-center">Projetos</h5>
              <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-6 py-2">
                <p><span class="text-sm text-zinc-400">Total:</span> {{ statistic?.projects.total ?? 0 }} </p>
                <p><span class="text-sm text-zinc-400">Ativos:</span> {{ statistic?.projects.active ?? 0 }} </p>
                <p><span class="text-sm text-zinc-400">Arquivadas:</span> {{ statistic?.projects.archived ?? 0 }} </p>
              </div>
              <hr class="my-4 text-zinc-800">
              <h5 class="text-center">Tasks</h5>
              <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-6 py-2">
                <p><span class="text-sm text-zinc-400">Total:</span> {{ statistic?.tasks.total ?? 0 }}</p>
                <p><span class="text-sm text-zinc-400">Pendentes:</span> {{ statistic?.tasks.todo ?? 0 }}</p>
                <p><span class="text-sm text-zinc-400">Em Processo:</span> {{ statistic?.tasks.in_progress ?? 0 }}</p>
                <p><span class="text-sm text-zinc-400">Concluidos:</span> {{ statistic?.tasks?.done ?? 0 }}</p>
              </div>
            </div>
          </div>
        </section>

        <section class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5 sm:p-6 space-y-4">
          <h3 class="text-base sm:text-lg font-semibold text-zinc-100 border-b border-zinc-800 pb-3">
            Informações do Usuário
          </h3>
          <div class="flex flex-col text-sm sm:text-base gap-3 text-zinc-300">
            <span class="text-zinc-400 font-medium">Nome: {{ authStore.user?.name }}</span>
            <span class="text-zinc-400 font-medium">Email: {{ authStore.user?.email }}</span>
            <span class="text-zinc-400 font-medium">Criado em:
              {{ formatDate(authStore.user?.created_at)}}
            </span>
            <button
              class="bg-red-900/70 rounded-xl p-0.5 transition-transform duration-200 hover:-translate-y-1 hover:bg-red-900">
              Deletar conta
            </button>
          </div>
        </section>
      </div>
    </div>
  </MainLayout>
</template>
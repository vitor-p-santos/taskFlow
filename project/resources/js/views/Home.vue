<script setup lang="ts">
import { onMounted, ref } from 'vue'
import Card from '../components/ProjectCard.vue'
import Modal from '../components/Modal.vue'
import Loading from '../components/Loading.vue'
import { useProjects } from '../composables/useProjects.ts'

const { projects, loading, error, fetchProjects, newProject } = useProjects()
const isOpen = ref(false)

onMounted(() => {
  fetchProjects()
})

</script>

<template>
  <div class="min-h-screen bg-[#121212] text-neutral-100">
    <header class="border-b border-neutral-800 bg-neutral-900/50 backdrop-blur-md sticky top-0 z-40">
      <div class="max-w-7xl mx-auto py-6 px-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Gerenciador de Projetos</h1>
        <button 
          @click="isOpen = true" 
          class="bg-emerald-600 hover:bg-emerald-500 text-white font-medium px-4 py-2.5 rounded-xl transition-all"
        >
          Novo projeto
        </button>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
      <!-- Usando o componente reutilizável de loading -->
      <div v-if="loading">
        <Loading message="Buscando projetos..." size="lg" full-screen />
      </div>

      <div v-else-if="error" class="bg-red-950/40 border border-red-900/50 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
        {{ error }}
      </div>

      <div v-else-if="projects.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <Card 
          v-for="project in projects" 
          :key="project.id" 
          :id="project.id"
          :title="project.name" 
          :description="project.description"
          :created-at="project.created_at" 
          :status="project.status" 
          :task-count="project.tasks_count" 
        />
      </div>

      <div v-else class="text-center text-neutral-500 py-24 border border-dashed border-neutral-800 rounded-2xl">
        Nenhum projeto encontrado.
      </div>
    </main>

    <Modal 
      :is-open="isOpen" 
      :loading="loading"
      :error="error"
      @close="isOpen = false" 
      @submit="newProject" 
    />
  </div>
</template>
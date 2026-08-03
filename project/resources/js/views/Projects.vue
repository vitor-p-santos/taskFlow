<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { storeToRefs } from 'pinia'

import Card from '../components/ProjectCard.vue'
import ProjectModal from '../components/NewProjectModal.vue'
import Loading from '../components/Loading.vue'
import NavBar from '../layouts/NavBar.vue'

import { useProjectsStore } from '../stores/ProjectStore'
import { Project } from '../types/projectType'
import { errorToast, successToast } from '../lib/toast'

const projectStore = useProjectsStore()

const {
  projects,
  loading,
  error,
  prevUrl,
  nextUrl,
} = storeToRefs(projectStore)


const isOpen = ref(false)
const modalError = ref<any>(null)
const modalLoading = ref(false)

onMounted(() => {
  console.log('montando');
  
  projectStore.load()
})

const handleNextPage = () => {
  if (nextUrl.value) {
    projectStore.load( nextUrl.value )
  }
}

const handlePrevPage = () => {
  if (prevUrl.value) {
    projectStore.load( prevUrl.value )
  }
}

const handleCreateProject = async (projectData: Project) => {
  modalLoading.value = true
  modalError.value = null

  try {
    await projectStore.add(projectData)

    isOpen.value = false
    successToast('Novo projeto adicionado')
  } catch (err) {
    modalError.value = err
    errorToast('Erro ao criar projeto')
  } finally {
    modalLoading.value = false
  }
}

const handleClose = () => {
  isOpen.value = false
  modalError.value = null
}
</script>

<template>
  <div class="min-h-screen bg-[#121212] text-neutral-100">
    <NavBar title="Gerenciador de projetos" v-model:is-open="isOpen" name-button="Criar projeto" />

    <main class="max-w-7xl mx-auto px-4 py-8">
      <div v-if="loading">
        <Loading message="Buscando projetos..." size="lg" full-screen />
      </div>

      <div v-else-if="error"
        class="text-center bg-red-950/40 border border-red-900/50 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
        {{ error }}
      </div>

      <template v-else-if="projects.length > 0">

        <div class="flex justify-between items-center mb-8 pb-4 border-b border-neutral-800">
          <button @click="handlePrevPage" :disabled="!prevUrl"
            class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
            ← Anterior
          </button>

          <button @click="handleNextPage" :disabled="!nextUrl"
            class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
            Próxima →
          </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <Card v-for="project in projects" :key="project.id" :project="project" />
        </div>

        <div class="flex justify-between items-center mt-8 pt-4 border-t border-neutral-800">
          <button @click="handlePrevPage" :disabled="!prevUrl"
            class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
            ← Anterior
          </button>

          <button @click="handleNextPage" :disabled="!nextUrl"
            class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
            Próxima →
          </button>
        </div>
      </template>

      <div v-else class="text-center text-neutral-500 py-24 border border-dashed border-neutral-800 rounded-2xl">
        Nenhum projeto encontrado.
      </div>
    </main>

    <ProjectModal :is-open="isOpen" :loading="modalLoading" :error="modalError" @close="handleClose"
      @submit="handleCreateProject" />
  </div>
</template>
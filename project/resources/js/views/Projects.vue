<script setup lang="ts">
import { onMounted, reactive, ref, watch } from 'vue'
import { storeToRefs } from 'pinia'

import Card from '../components/projects/ProjectCard.vue'
import ProjectModal from '../components/projects/ProjectModal.vue'
import Loading from '../components/Loading.vue'
import NavBar from '../layouts/NavBar.vue'

import { useProjectsStore } from '../stores/ProjectStore'
import { Project, ProjectCreate } from '../types/projectType'
import { errorToast, successToast } from '../lib/toast'
import Paginate from '../components/paginate.vue'
import ProjectFilter from '../components/projects/ProjectFilter.vue'

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
const filterParams = reactive<{ name: string, status: string }>({ name: '', status: '' })

onMounted(() => {
  projectStore.load()
})

const handleNextPage = () => {
  if (nextUrl.value) {
    projectStore.load({ url: nextUrl.value })
  }
}

const handlePrevPage = () => {
  if (prevUrl.value) {
    projectStore.load({ url: prevUrl.value })
  }
}

const handleCreateProject = async (projectData: ProjectCreate) => {
  modalLoading.value = true
  modalError.value = null

  try {
    await projectStore.add(projectData)

    isOpen.value = false
    successToast(`Projeto ${projectData.name} criado!`)
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

let debounceTimeout: any

watch(filterParams, (newFilters) => {
  clearTimeout(debounceTimeout)
  
  debounceTimeout = setTimeout(() => {
   

    projectStore.load({ filter: newFilters })
  }, 800)
}, { deep: true })

</script>

<template>
  <main class="min-h-screen bg-[#121212] text-neutral-100" :inert="isOpen">
    <header>
      <NavBar title="Gerenciador de projetos" v-model:is-open="isOpen" name-button="Criar projeto" />
    </header>


    <ProjectFilter v-model:search-input="filterParams.name" v-model:status-select="filterParams.status" />
    <div class="max-w-7xl mx-auto px-4 py-4">

      <div v-if="loading">
        <Loading message="Buscando projetos..." size="lg" full-screen />
      </div>

      <div v-else-if="error"
        class="text-center bg-red-950/40 border border-red-900/50 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
        {{ error }}
      </div>

      <div v-else-if="projects.length > 0">

        <Paginate :next-url="nextUrl" @handle-next-page="handleNextPage" :prev-url="prevUrl"
          @handle-prev-page="handlePrevPage" border-position="bottom" />


        <div aria-label="Lista de projetos" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <article v-for="project in projects" :key="project.id">
            <Card :project="project" />
          </article>
        </div>

        <Paginate :next-url="nextUrl" @handle-next-page="handleNextPage" :prev-url="prevUrl"
          @handle-prev-page="handlePrevPage" border-position="top" />
      </div>

      <div v-else class="text-center text-neutral-500 py-24 border border-dashed border-neutral-800 rounded-2xl">
        Nenhum projeto encontrado.
      </div>
    </div>
  </main>

  <aside aria-label="Criar novo projeto">
    <ProjectModal :is-open="isOpen" :loading="modalLoading" :error="modalError" @close="handleClose"
      @submit="handleCreateProject" />
  </aside>
</template>
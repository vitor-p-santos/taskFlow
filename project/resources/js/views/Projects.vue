<script setup lang="ts">
import { onMounted, reactive, ref, watch } from 'vue'
import { storeToRefs } from 'pinia'

import MainLayout from '../layouts/MainLayout.vue'
import NavBar from '../layouts/NavBar.vue'
import ProjectFilter from '../components/projects/ProjectFilter.vue'
import Card from '../components/projects/ProjectCard.vue'
import ProjectModal from '../components/projects/ProjectModal.vue'
import Loading from '../components/Loading.vue'
import Paginate from '../components/paginate.vue'

import { useProjectsStore } from '../stores/ProjectStore'
import { FetchProjectParams, ProjectCreate } from '../types/project'
import { errorToast, successToast } from '../lib/toast'
import { Plus } from 'lucide-vue-next'

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
const filterParams = reactive<FetchProjectParams>({ name: '', status: '' })

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

let debounceTimeout: ReturnType<typeof setTimeout>

watch(
  filterParams,
  (newFilters) => {
    clearTimeout(debounceTimeout)
    debounceTimeout = setTimeout(() => {
      projectStore.load({ filter: newFilters })
    }, 800)
  },
  { deep: true }
)
</script>

<template>
  <MainLayout :inert="isOpen">
    <template #header>
      <NavBar 
        title="Gerenciador de projetos" 
      >
    
        <button @click="() => isOpen = true"
          class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition-all duration-200 hover:bg-emerald-500 hover:shadow-lg hover:shadow-emerald-900/30 active:scale-95 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-900">
          <Plus class="h-4 w-4" />

          <span>Criar projeto</span>
        </button>
    </NavBar>
    </template>

    <!-- Conteúdo principal -->
    <ProjectFilter 
      v-model:search-input="filterParams.name" 
      v-model:status-select="filterParams.status" 
    />

    <Transition 
      enter-active-class="transition-all duration-500 ease-out"
      enter-from-class="opacity-0 translate-y-7" 
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition-all duration-500 ease-in" 
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-7"
    >
      <div v-if="loading">
        <Loading message="Buscando projetos..." size="lg" full-screen />
      </div>

      <div 
        v-else-if="error"
        class="text-center bg-red-950/40 border border-red-900/50 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm"
      >
        {{ error }}
      </div>

      <div v-else-if="projects.length > 0" class="space-y-6">
        <Paginate 
          :next-url="nextUrl" 
          @handle-next-page="handleNextPage" 
          :prev-url="prevUrl"
          @handle-prev-page="handlePrevPage" 
          border-position="bottom" 
        />

          <TransitionGroup 
            name="list" 
            tag="ul"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6"
            enter-active-class="transition-all duration-500 ease-out" 
            enter-from-class="opacity-0 translate-y-7"
            enter-to-class="opacity-100 translate-y-0" 
            leave-active-class="transition-all duration-500 ease-in"
            leave-from-class="opacity-100 translate-y-0" 
            leave-to-class="opacity-0 translate-y-7"
          >
            <li v-for="project in projects" :key="project.id">
              <Card :project="project" />
            </li>
          </TransitionGroup>

        <Paginate 
          :next-url="nextUrl" 
          @handle-next-page="handleNextPage" 
          :prev-url="prevUrl"
          @handle-prev-page="handlePrevPage" 
          border-position="top" 
        />
      </div>

      <div v-else class="text-center text-neutral-500 py-24 border border-dashed border-neutral-800 rounded-2xl">
        Nenhum projeto encontrado.
      </div>
    </Transition>
  </MainLayout>

  <Teleport to="body">
    <ProjectModal 
      :is-open="isOpen" 
      :loading="modalLoading" 
      :error="modalError" 
      @close="handleClose"
      @submit="handleCreateProject" 
    />
  </Teleport>
</template>
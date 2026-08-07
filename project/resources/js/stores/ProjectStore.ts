import { defineStore } from 'pinia'
import { ref } from 'vue'
import { Project, ProjectCreate } from '../types/projectType'
import {
  fetchProjects,
  createProject,
} from '../composables/useProjects'

interface LoadOptions {
  url?: string
  filter?: {
    name?: string
    status?: string
  }
}

export const useProjectsStore = defineStore('projects', () => {
  const projects = ref<Project[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  const nextUrl = ref<string>('')
  const prevUrl = ref<string>('')

  async function load(options: LoadOptions = {}) {
    
    loading.value = true
    error.value = null

    try {
      const resp = await fetchProjects(options.url, options.filter)


      projects.value = resp.data
      nextUrl.value = resp.meta.next_page_url
      prevUrl.value = resp.meta.prev_page_url
    } catch (err) {
      error.value =
        err instanceof Error ? err.message : 'Erro inesperado'
    } finally {
      loading.value = false
    }
  }

  async function add(data: ProjectCreate) {
    const resp = await createProject(data)

    projects.value.unshift(resp.data)

    if (projects.value.length > 9) {
      projects.value.pop()
    }

    return resp.message
  }

  return {
    projects,
    loading,
    error,
    nextUrl,
    prevUrl,
    load,
    add,
  }
})
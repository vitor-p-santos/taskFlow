import { useProjectsStore } from '../stores/ProjectStore'
import { storeToRefs } from 'pinia'
import { Project } from '../types/projectType'

export function useProjects() {
  const store = useProjectsStore()

  const {
    projects,
    loading,
    error,
    nextUrl,
    prevUrl,
  } = storeToRefs(store)

  const fetchProjects = async (url = '/api/projects') => {
    store.loading = true
    store.error = null

    try {
      const response = await fetch(url, {
        headers: {
          Accept: 'application/json'
        }
      })

      const resp = await response.json()

      if (!response.ok) {
        throw new Error(resp.message || 'Falha ao buscar projetos.')
      }

      store.projects = resp.data
      store.nextUrl = resp.meta.next_page_url
      store.prevUrl = resp.meta.prev_page_url

    } catch (err) {
      console.error(err)
      store.error = err instanceof Error ? err.message : 'Erro desconhecido'
    } finally {
      store.loading = false
    }
  }

  const newProject = async (data: Project) => {
    try {
      const response = await fetch('/api/projects', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json'
        },
        body: JSON.stringify(data)
      })

      const resp = await response.json()

      if (!response.ok) {
        throw resp.errors
      }

      projects.value.unshift(data)

      if (projects.value.length > 9) {
        projects.value.pop()
      }

      return resp.message
    } catch (err) {
      throw err
    }
  }

  return {
    projects,
    loading,
    error,
    nextUrl,
    prevUrl,
    fetchProjects,
    newProject
  }
}
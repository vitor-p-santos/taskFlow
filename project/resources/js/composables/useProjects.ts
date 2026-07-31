import { ref } from 'vue'

export interface Project {
  id: number
  name: string
  status: string
  description: string
  created_at: string
  tasks_count: number
}

export const useProjects = () => {
  const projects = ref<Project[] | []>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  const fetchProjects = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await fetch('/api/projects')

      if (!response.ok) {
        throw new Error('Falha ao buscar projetos.')
      }

      const resp = await response.json()
      projects.value = resp.data

    } catch (err) {
      console.error(err)
    } finally {
      loading.value = false
    }
  }

  const newProject = async (data: Project) => {
    loading.value = true
    error.value = null

    try {
      const response = await fetch('/api/projects', {
        method: 'post',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(data)
      })

      if (!response.ok) {
        throw new Error('Falha ao criar projeto.')
      }

      const resp = await response.json()
      projects.value = resp.data
      fetchProjects()
    } catch (err) {
      console.error(err)
    } finally {
      loading.value = false
    }
  }

  return {
    projects,
    loading,
    error,
    fetchProjects,
    newProject
  }
}
import { ref } from 'vue'

export interface Task {
  id: number
  title: string
  description: string
  status: string
  priority: string
  due_date: string
  created_at: string
}

export const useTask = () => {
  const tasks = ref<Task[] | []>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  const fetchTask = async (id: number) => {
    loading.value = true
    error.value = null

    try {
      const response = await fetch(`/api/projects/${id}/tasks`, {
        headers: {
          "content-type": "application/json"
        }
      })

      if (!response.ok) {
        throw new Error('Falha ao buscar projetos.')
      }

      const resp = await response.json()
      tasks.value = resp.data

    } catch (err) {
      console.error(err)
    } finally {
      loading.value = false
    }
  }

  const newTask = async (id: number, body: Task) => {
    loading.value = true
    error.value = null

    try {
      const response = await fetch(`/api/projects/${id}/tasks`, {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          "content-type": "application/json"
        },
      })

      if (!response.ok) {
        throw new Error('Falha ao buscar projetos.')
      }

      const resp = await response.json()
      tasks.value = resp.data

    } catch (err) {
      console.error(err)
    } finally {
      loading.value = false
    }
  }

  const patchTask = async (id: number) => {
    loading.value = true
    error.value = null

    try {
      const response = await fetch(`/api/projects/${id}/tasks`, {
        method: 'PATCH',
        headers: {
          "content-type": "application/json"
        }
      })

      if (!response.ok) {
        throw new Error('Falha ao buscar projetos.')
      }

      const resp = await response.json()
      tasks.value = resp.data

    } catch (err) {
      console.error(err)
    } finally {
      loading.value = false
    }
  }

  const deleteTask = async (id: number) => {
    loading.value = true
    error.value = null

    try {
      const response = await fetch(`/api/projects/${id}/tasks`, {
        method: 'DELETE',
        headers: {
          "content-type": "application/json"
        }
      })

      if (!response.ok) {
        throw new Error('Falha ao buscar projetos.')
      }

      const resp = await response.json()
      tasks.value = resp.data

    } catch (err) {
      console.error(err)
    } finally {
      loading.value = false
    }
  }

  return {
    tasks,
    loading,
    error,
    fetchTask,
    newTask,
    patchTask,
    deleteTask
  }
}
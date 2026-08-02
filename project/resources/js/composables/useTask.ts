import { useTasksStore } from '../stores/TaskStore'
import { storeToRefs } from 'pinia'
import { Task } from '../types/Task'

type FetchTaskParams = {
  id: number
  filters?: {
    status?: string
    priority?: string
    due_date?: boolean
  }
  url?: string
}

export function useTask() {
  const store = useTasksStore()
  const { tasks, loading, error, nextUrl, prevUrl } = storeToRefs(store)

  const fetchTask = async ({
    id,
    filters,
    url
  }: FetchTaskParams) => {
    store.loading = true
    store.error = null
    
    console.log(id, url);
    
    try {
      const requestUrl = url
        ? new URL(url)
        : new URL(`/api/projects/${id}/tasks`, window.location.origin)

      if (!url && filters) {
        if (filters.status) {
          requestUrl.searchParams.append('status', filters.status)
        }

        if (filters.priority) {
          requestUrl.searchParams.append('priority', filters.priority)
        }

        if (filters.due_date) {
          requestUrl.searchParams.append('due_date', 'true')
        }
      }

      const response = await fetch(requestUrl.toString(), {
        headers: {
          Accept: 'application/json'
        }
      })
      
      const resp = await response.json()
      console.log(resp);

      if (!response.ok) {
        throw new Error('Falha ao buscar tarefas.')
      }


      store.tasks = resp.data
      store.nextUrl = resp.meta.next_page_url;
      store.prevUrl = resp.meta.prev_page_url

    } catch (err) {
      store.error = err instanceof Error ? err.message : 'Erro desconhecido'
      console.error(err)
    } finally {
      store.loading = false
    }
  }

  const newTask = async ({ projectId, taskData }: { projectId: number; taskData: Task }) => {

    try {
      const response = await fetch(`/api/projects/${projectId}/tasks`, {
        method: 'POST',
        body: JSON.stringify(taskData),
        headers: {
          "content-type": "application/json",
          "Accept": "application/json"
        },
      })

      const resp = await response.json()

      if (!response.ok) {
        throw resp.errors
      }

      store.tasks.push(resp.data)

      return resp.message
    } catch (err: any) {
      throw err

    }
  }

  const patchTask = async ({
    taskId,
    patchData
  }: {
    taskId: number,
    patchData: { status?: string, priority?: string }
  }) => {

    try {
      const response = await fetch(`/api/tasks/${taskId}`, {
        method: 'PATCH',
        headers: {
          "content-type": "application/json",
          "Accept": "application/json"
        },
        body: JSON.stringify(patchData)
      })

      const resp = await response.json()

      if (!response.ok) {
        throw new Error('Falha ao atualizar a tarefa.')
      }

    } catch (err) {
      throw err
      console.error(err)
    }
  }

  const deleteTask = async (id: number) => {

    try {
      const response = await fetch(`/api/tasks/${id}`, {
        method: 'DELETE',
        headers: {
          "content-type": "application/json",
          "Accept": "application/json"
        }
      })

      if (!response.ok) {
        throw new Error('Falha ao deletar a tarefa.')
      }

      store.tasks = store.tasks.filter(task => task.id !== id)

    } catch (err) {
      store.error = err instanceof Error ? err.message : 'Erro desconhecido'
      console.error(err)
    }
  }

  return {
    tasks,
    loading,
    error,
    nextUrl,
    prevUrl,
    fetchTask,
    newTask,
    patchTask,
    deleteTask
  }
}
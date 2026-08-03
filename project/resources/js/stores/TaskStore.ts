import { defineStore } from 'pinia'
import { ref } from 'vue'
import { FetchTaskParams, Task } from '../types/Task'
import {
  fetchTasks,
  createTask,
  updateTask,
  removeTask,
} from '../composables/useTask'

export const useTasksStore = defineStore('tasks', () => {
  const tasks = ref<Task[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)
  const nextUrl = ref('')
  const prevUrl = ref('')

  async function load(params: FetchTaskParams) {
    loading.value = true
    error.value = null

    try {
      const resp = await fetchTasks(params)

      tasks.value = resp.data
      nextUrl.value = resp.meta.next_page_url
      prevUrl.value = resp.meta.prev_page_url
    } catch (err) {
      error.value =
        err instanceof Error ? err.message : 'Erro desconhecido'
    } finally {
      loading.value = false
    }
  }

  async function create(projectId: number, task: Task) {
    const resp = await createTask(projectId, task)

    tasks.value.push(resp.data)

    return resp.message
  }

  async function patch(
    taskId: number,
    patchData: {
      status?: string
      priority?: string
    }
  ) {
    await updateTask(taskId, patchData)
  }

  async function remove(taskId: number) {
    await removeTask(taskId)

    tasks.value = tasks.value.filter(t => t.id !== taskId)
  }

  return {
    tasks,
    loading,
    error,
    nextUrl,
    prevUrl,
    load,
    create,
    patch,
    remove,
  }
})
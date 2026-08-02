import { defineStore } from 'pinia'
import { ref } from 'vue'
import { Task } from '../types/Task'

export const useTasksStore = defineStore('tasks', () => {
  const tasks = ref<Task[]>([])
  const loading = ref<boolean>(false)
  const error = ref<string | null>(null)
  const nextUrl = ref<string >('')
  const prevUrl = ref<string >('')

  return {
    tasks,
    loading,
    error,
    nextUrl,
    prevUrl,
  }
})
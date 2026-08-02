import { defineStore } from 'pinia'
import { ref } from 'vue'
import { Project } from '../types/projectType'

export const useProjectsStore = defineStore('projects', () => {
  const projects = ref<Project[]>([])
  const prevUrl = ref<string>('');
  const nextUrl = ref<string>('');
  const loading = ref<boolean>(false)
  const error = ref<string | null>(null)

  return {
    projects,
    loading,
    error,
    prevUrl,
    nextUrl,
  }
})
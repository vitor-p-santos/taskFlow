export interface Project {
  id: number
  name: string
  status: string
  description: string
  created_at: string
  tasks_count: number
}

export type ProjectCreate = {
  name: string
  status: string
  description: string
}

export type ProjectUpdate = {
  name?: string
  status?: string
  description?: string
}
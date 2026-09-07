export interface Project {
  id: number
  name: string
  status: string
  description: string
  created_at: string
  tasks_count: number
}

export interface FetchProjectParams 
{ name: string; status: string }

export interface ProjectCreate {
  name: string
  status: string
  description: string
}

export interface ProjectUpdate {
  name?: string
  status?: string
  description?: string
}
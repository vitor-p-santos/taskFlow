
export interface Task {
  id: number
  title: string
  description: string
  status: string
  priority: string
  due_date: string
  created_at: string
}

export interface FetchTaskParams {
  id: number
  filters?: {
    status?: string
    priority?: string
    due_date?: boolean
  }
  url?: string
}


export interface TaskCreate {
  title: string
  description: string
  status: string
  priority: string
  due_date: string
}


export interface patchTask {
  status?: string,
  priority?: string,
}

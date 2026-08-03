
export type Task = {
  id?: number
  title: string
  description: string
  status: string
  priority: string
  due_date: string
  created_at: string
}



export type FetchTaskParams = {
  id: number
  filters?: {
    status?: string
    priority?: string
    due_date?: boolean
  }
  url?: string
}

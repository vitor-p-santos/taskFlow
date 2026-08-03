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

export async function fetchTasks({
  id,
  filters,
  url,
}: FetchTaskParams) {
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
      Accept: 'application/json',
    },
  })

  const resp = await response.json()

  if (!response.ok) {
    throw new Error('Por favor tente novamente mais tarde!')
  }

  return resp
}

export async function createTask(
  projectId: number,
  taskData: Task
) {
  const response = await fetch(`/api/projects/${projectId}/tasks`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
    body: JSON.stringify(taskData),
  })

  const resp = await response.json()

  if (!response.ok) {
    throw resp.errors
  }

  return resp
}

export async function updateTask(
  taskId: number,
  patchData: {
    status?: string
    priority?: string
  }
) {
  const response = await fetch(`/api/tasks/${taskId}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
    body: JSON.stringify(patchData),
  })

  const resp = await response.json()

  if (!response.ok) {
    throw new Error('Falha ao atualizar a tarefa. Tente novamente')
  }

  return resp
}

export async function removeTask(taskId: number) {
  const response = await fetch(`/api/tasks/${taskId}`, {
    method: 'DELETE',
    headers: {
      Accept: 'application/json',
    },
  })

  const resp = await response.json()

  if (!response.ok) {
    throw new Error('Falha ao deletar a tarefa. Tente novamente')
  }
}
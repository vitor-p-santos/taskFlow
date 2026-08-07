import { ProjectCreate } from '../types/projectType'

export async function fetchProjects(
  url = '/api/projects',
  filters?: { name?: string; status?: string }
) {
  const requestUrl = new URL(url, window.location.origin)

  if (filters?.status) {
    requestUrl.searchParams.set('status', filters.status)
  }

  if (filters?.name) {
    requestUrl.searchParams.set('name', filters.name)
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

export async function createProject(data: ProjectCreate) {
  const response = await fetch('/api/projects', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
    body: JSON.stringify(data),
  })

  const resp = await response.json()

  if (!response.ok) {
    throw resp.errors || resp.message
  }

  return resp
}
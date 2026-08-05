import { Project, ProjectCreate } from '../types/projectType'

export async function fetchProjects(url = '/api/projects') {
  const response = await fetch(url, {
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
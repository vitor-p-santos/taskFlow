import { test, expect } from 'vitest'
import { fetchProjects } from '../composables/useProjects'

const apiUrl = {
  docker: 'http://nginx:80', 
  local: 'http://localhost:8000'
}
console.log(apiUrl);

test('list projects', async () => {
  
  const projects = await fetchProjects(`${apiUrl.docker}/api/projects`)

  expect(projects).toBeDefined()
  console.log(projects);
  
})
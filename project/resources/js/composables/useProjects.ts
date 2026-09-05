import { api } from '../lib/axios';
import { ProjectCreate } from '../types/project'

// ==========================================
// 📁 PROJECTS
// ==========================================



export async function fetchProjects(
  url = '/projects',
  filters?: { name?: string; status?: string }
) {
  try{

    const response = await api.get(url, {
      params: {
        status: filters?.status,
        name: filters?.name,
      },
    });
    
    return response.data;
  }catch(err : any){
    
  }
}

export async function createProject(data: ProjectCreate) {
  try {
    const response = await api.post('/projects', data);
    return response.data;
  } catch (err: any) {
    throw err.response?.data?.errors || err.response?.data?.message || 'Erro ao criar projeto';
  }
}


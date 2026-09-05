import { api } from '../lib/axios';
import { TaskCreate } from '../types/Task';

// ==========================================
// 📋 TASKS
// ==========================================

type FetchTaskParams = {
  id: number;
  filters?: {
    status?: string;
    priority?: string;
    due_date?: boolean;
  };
  url?: string;
};

export async function fetchTasks({
  id,
  filters,
  url,
}: FetchTaskParams) {
  const endpoint = url || `/projects/${id}/tasks`;

  const response = await api.get(endpoint, {
    params: {
      status: filters?.status,
      priority: filters?.priority,
      due_date: filters?.due_date ? 'true' : undefined,
    },
  });

  return response.data;
}

export async function createTask(
  projectId: number,
  taskData: TaskCreate
) {
  try {
    const response = await api.post(`/projects/${projectId}/tasks`, taskData);
    return response.data;
  } catch (err: any) {
    throw err.response?.data?.errors || 'Erro ao criar tarefa';
  }
}

export async function updateTask(
  taskId: number,
  patchData: {
    status?: string;
    priority?: string;
  }
) {
  try {
    const response = await api.patch(`/tasks/${taskId}`, patchData);
    return response.data;
  } catch (err: any) {
    throw new Error(err.response?.data?.message || 'Falha ao atualizar a tarefa. Tente novamente');
  }
}

export async function removeTask(taskId: number) {
  try {
    const response = await api.delete(`/tasks/${taskId}`);
    return response.data;
  } catch (err: any) {
    throw new Error(err.response?.data?.message || 'Falha ao deletar a tarefa. Tente novamente');
  }
}
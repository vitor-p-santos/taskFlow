<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import Loading from '../components/Loading.vue'
import { useTasksStore } from '../stores/TaskStore.ts'
import { useRoute, useRouter } from 'vue-router'
import NewTaskModal from '../components/tasks/NewTaskModal.vue'
import { patchTask, Task, TaskCreate } from '../types/Task'
import NavBar from '../layouts/NavBar.vue'
import TaskCard from '../components/tasks/TaskCard.vue'
import TaskFilter from '../components/tasks/TaskFilter.vue'
import { successToast, errorToast } from '../lib/toast.ts'
import { ArrowLeft } from 'lucide-vue-next'
import { storeToRefs } from 'pinia'
import Paginate from '../components/paginate.vue'
import { useProjectsStore } from '../stores/ProjectStore.ts'
import { Project } from '../types/projectType'

const projectStore = useProjectsStore()
const taskStore = useTasksStore()

const {
  tasks,
  loading,
  error,
  nextUrl,
  prevUrl,
} = storeToRefs(taskStore)

const route = useRoute()
const router = useRouter()
const projectId = Number(route.params.id)
const projectFind = ref<Project>(
  projectStore.projects.find((p) => p.id === projectId)!
);

const filterStatus = ref<string>('')
const filterPriority = ref<string>('')
const dueDate = ref<boolean>(false)

const isOpen = ref<boolean>(false)

const modalError = ref<any>(null)
const modalLoading = ref<boolean>(false)

const patchLoadingId = ref<number | null>(null)

const loadingTaskId = ref<number | null>(null)

const loadTasks = () => {

  taskStore.load({
    id: projectId,
    filters: {
      status: filterStatus.value,
      priority: filterPriority.value,
      due_date: dueDate.value
    }
  })
}

onMounted(() => {
  loadTasks()
})

let timer: ReturnType<typeof setTimeout>

const debounceLoadTasks = () => {
  clearTimeout(timer)

  timer = setTimeout(() => {

    loadTasks()
  }, 800)
}

watch(
  [filterStatus, filterPriority, dueDate],
  () => debounceLoadTasks()
)


const handleNextPage = () => {
  if (nextUrl.value) {
    taskStore.load({ id: projectId, url: nextUrl.value })
  }
}

const handlePrevPage = () => {
  if (prevUrl.value) {
    taskStore.load({ id: projectId, url: prevUrl.value })
  }
}


const handleCreateTask = async (taskData: TaskCreate) => {
  modalLoading.value = true
  modalError.value = null

  try {
    await taskStore.create(projectId, taskData)
    isOpen.value = false
    successToast(`Tarefa ${taskData.title} foi criada!`)

  } catch (err) {
    errorToast('erro')
    modalError.value = err
  } finally {
    modalLoading.value = false
  }
}

const handlePatch = async ({
  taskId,
  patchData
}: {
  taskId: number,
  patchData: patchTask
}) => {
  const taskFind = tasks.value.find((t) => t.id === taskId);

  if (!taskFind) return

  const oldValueProproty = taskFind.priority
  const oldValueStatus = taskFind.status

  if (patchData.status) taskFind.status = patchData.status
  if (patchData.priority) taskFind.priority = patchData.priority

  patchLoadingId.value = taskId;
  try {

    await new Promise((resolve) => {
      setTimeout(() => {
        resolve(true);
      }, 800);
    });

    await taskStore.patch(taskId, patchData)

    const match = {
      'todo': 'Pendente',
      'in_progress': 'Em Progresso',
      'done': 'Concluído',
      'low': 'Baixa',
      'medium': 'Média',
      'high': 'Alta'
    } as const;

    const key = (patchData.priority ?? patchData.status) as keyof typeof match;

    successToast(`Tarefa: ${taskFind.title} foi atualizado para ${match[key]}`);

  } catch (err) {
    errorToast(err instanceof Error ? err.message : 'Falha ao atualizar');

    taskFind.status = oldValueStatus
    taskFind.priority = oldValueProproty
  } finally {
    patchLoadingId.value = null;
  }
}

const handleDelete = async (task: Task) => {

  loadingTaskId.value = task.id

  const taskFind = tasks.value.find((t) => t.id === task.id);

  if (!taskFind) return

  try {
    await taskStore.remove(task.id)
    successToast(`Tarefa ${taskFind.title} deletada!`);
  } catch (err) {
    errorToast(err instanceof Error ? err.message : 'Falha ao deletar');
  } finally {
    loadingTaskId.value = null
  }
}

const handleClearFilter = () => {
  filterStatus.value = ''
  filterPriority.value = ''
  dueDate.value = false

}

const handleClose = () => {
  isOpen.value = false
  modalError.value = null
}
</script>

<template>
  <main class="min-h-screen bg-[#121212] text-neutral-100">
    <NavBar :title="projectFind?.name" v-model:is-open="isOpen" name-button="Criar tarefa">
      <button @click="router.push('/')"
        class="inline-flex items-center gap-2 rounded-xl border border-neutral-700 bg-neutral-800 px-4 py-2.5 text-sm font-medium text-neutral-300 transition-all duration-200 hover:border-neutral-600 hover:bg-neutral-700 hover:text-white hover:shadow-lg hover:shadow-black/20 active:scale-95 focus:outline-none focus:ring-2 focus:ring-neutral-500 focus:ring-offset-2 focus:ring-offset-neutral-900">
        <ArrowLeft class="h-4 w-4" />
        <span>Voltar</span>
      </button>
    </NavBar>

    <TaskFilter v-model:status="filterStatus" v-model:priority="filterPriority" v-model:due-date="dueDate"
      v-on:clear-filter="handleClearFilter" />

    <div class="max-w-7xl mx-auto px-4 py-4">
      <div v-if="loading">
        <Loading message="Buscando tarefas..." size="lg" full-screen />
      </div>

      <div v-else-if="error"
        class="bg-red-950/40 border border-red-900/50 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
        {{ error }}
      </div>

      <div v-else-if="tasks.length > 0">
        <Paginate :prev-url="prevUrl" :next-url="nextUrl" @handle-prev-page="handlePrevPage"
          @handle-next-page="handleNextPage" border-position="bottom" />


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 items-start">

          <TaskCard v-for="task in tasks" :key="task.id" :task="task" @patch="handlePatch" @delete="handleDelete"
            :loading="loadingTaskId === task.id" :patch-loading="patchLoadingId === task.id" />
        </div>

        <Paginate :prev-url="prevUrl" :next-url="nextUrl" @handle-prev-page="handlePrevPage"
          @handle-next-page="handleNextPage" border-position="top" />

      </div>

      <div v-else class="text-center text-neutral-500 py-24 border border-dashed border-neutral-800 rounded-2xl">
        Nenhuma tarefa encontrada.
      </div>
    </div>


  </main>

  <aside>
    <NewTaskModal :is-open="isOpen" :loading="modalLoading" :error="modalError" @close="handleClose"
      @submit="handleCreateTask" />
  </aside>
</template>
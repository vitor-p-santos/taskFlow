<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import Loading from '../components/Loading.vue'
import { useTask } from '../composables/useTask.ts'
import { useRoute, useRouter } from 'vue-router'
import NewTaskModal from '../components/NewTaskModal.vue'
import { Task } from '../types/Task'
import NavBar from '../layouts/NavBar.vue'
import TaskCard from '../components/TaskCard.vue'
import Filter from '../layouts/Filter.vue'
import Swal from 'sweetalert2'
import { successToast, errorToast } from '../lib/toast.ts'
import { ArrowLeft } from 'lucide-vue-next'

const { tasks, loading, error, nextUrl, prevUrl, fetchTask, newTask, patchTask, deleteTask } = useTask()

const route = useRoute()
const router = useRouter()

const filterStatus = ref<string>('')
const filterPriority = ref<string>('')
const dueDate = ref<boolean>(false)

const isOpen = ref<boolean>(false)
const projectId = Number(route.params.id)

const modalError = ref<any>(null)
const modalLoading = ref<boolean>(false)

const patchLoadingId = ref<number | null>(null)

const loadingTaskId = ref<number | null>(null)

const loadTasks = () => {
  fetchTask({
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
    
  }, 300)
}

watch(
  [filterStatus, filterPriority, dueDate],
  debounceLoadTasks
)


const handleNextPage = () => {
  if (nextUrl.value) {
    fetchTask({ id: projectId, url: nextUrl.value })
  }
}

const handlePrevPage = () => {
  if (prevUrl.value) {
    fetchTask({ id: projectId, url: prevUrl.value })
  }
}


const handleCreateTask = async (taskData: Task) => {
  modalLoading.value = true
  modalError.value = null

  try {
    await newTask({ projectId, taskData })
    isOpen.value = false
    successToast('tarefa criada')

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
  patchData: { status?: string, priority?: string }
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

    await patchTask({ taskId, patchData })
    successToast('Conteúdo atualizado!');
  } catch (err) {
    errorToast('erro');

    taskFind.status = oldValueStatus
    taskFind.priority = oldValueProproty
  } finally {
    patchLoadingId.value = null;
  }
}

const handleDelete = async (taskId: number) => {

  loadingTaskId.value = taskId
  try {
    await deleteTask(taskId)
    successToast('tarefa deletada');
  } catch (err) {
    errorToast('erro');
  } finally {

    loadingTaskId.value = null
  }
}

const handleClose = () => {
  isOpen.value = false
  modalError.value = null
}
</script>

<template>
  <div class="min-h-screen bg-[#121212] text-neutral-100">
    <NavBar title="Painel de tarefas" v-model:is-open="isOpen" name-button="Criar tarefa">
      <button @click="router.push('/')"
        class="inline-flex items-center gap-2 rounded-xl border border-neutral-700 bg-neutral-800 px-4 py-2.5 text-sm font-medium text-neutral-300 transition-all duration-200 hover:border-neutral-600 hover:bg-neutral-700 hover:text-white hover:shadow-lg hover:shadow-black/20 active:scale-95 focus:outline-none focus:ring-2 focus:ring-neutral-500 focus:ring-offset-2 focus:ring-offset-neutral-900">
        <ArrowLeft class="h-4 w-4" />
        <span>Voltar</span>
      </button>
    </NavBar>

    <Filter v-model:status="filterStatus" v-model:priority="filterPriority" v-model:due-date="dueDate" />

    <main class="max-w-7xl mx-auto px-4 py-4">
      <div v-if="loading">
        <Loading message="Buscando tarefas..." size="lg" full-screen />
      </div>

      <div v-else-if="error"
        class="bg-red-950/40 border border-red-900/50 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
        {{ error }}
      </div>

      <div v-else-if="tasks.length > 0">
        <div class="flex justify-between items-center mb-8 pb-4 border-b border-neutral-800">
          <button @click="handlePrevPage" :disabled="!prevUrl"
            class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
            ← Anterior
          </button>

          <button @click="handleNextPage" :disabled="!nextUrl"
            class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
            Próxima →
          </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 items-start">

          <TaskCard v-for="task in tasks" :key="task.id" :task="task" @patch="handlePatch" @delete="handleDelete"
            :loading="loadingTaskId === task.id" :patch-loading="patchLoadingId === task.id" />
        </div>

        <div class="flex justify-between items-center mt-8 pt-4 border-t border-neutral-800">
          <button @click="handlePrevPage" :disabled="!prevUrl"
            class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
            ← Anterior
          </button>

          <button @click="handleNextPage" :disabled="!nextUrl"
            class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
            Próxima →
          </button>
        </div>

      </div>

      <div v-else class="text-center text-neutral-500 py-24 border border-dashed border-neutral-800 rounded-2xl">
        Nenhuma tarefa encontrada.
      </div>
    </main>

    <NewTaskModal :is-open="isOpen" :loading="modalLoading" :error="modalError" @close="handleClose"
      @submit="handleCreateTask" />
  </div>
</template>
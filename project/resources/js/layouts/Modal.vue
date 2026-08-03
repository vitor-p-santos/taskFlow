<script setup lang="ts">
import Loading from '../components/Loading.vue'

defineProps<{
  isOpen: boolean
  loading?: boolean
  title: string
  description?: string
}>()

const emit = defineEmits(['close'])

const close = () => {
  emit('close')
}
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
    
    <div class="fixed inset-0 bg-black/70 backdrop-blur-xs transition-opacity" @click="!loading && close()"></div>

    
    <div
      class="relative z-10 w-full max-w-md rounded-2xl bg-neutral-900 p-6 shadow-2xl border border-neutral-800 flex flex-col gap-6">

    
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-lg font-semibold text-white tracking-wide">{{ title }}</h3>
          <p v-if="description" class="text-xs text-neutral-400 mt-0.5">{{ description }}</p>
        </div>
        <button @click="close" :disabled="loading"
          class="w-8 h-8 flex items-center justify-center rounded-lg text-neutral-400 hover:text-white hover:bg-neutral-800 transition-colors disabled:opacity-50">
          ✕
        </button>
      </div>

      <div v-if="loading" class="py-6">
        <Loading size="md" message="Carregando..." />
      </div>

      <div v-else>
        <slot></slot>
      </div>

    </div>
  </div>
</template>
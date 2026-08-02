<script setup lang="ts">
import { Plus } from 'lucide-vue-next'

defineProps<{
  isOpen: boolean
  title: string
  nameButton: string
}>()

const emit = defineEmits<{
  (e: 'update:isOpen', value: boolean): void
}>()

const openModal = () => {
  emit('update:isOpen', true)
}
</script>

<template>
  <header class="sticky top-0 z-40 border-b border-neutral-800 bg-neutral-900/70 backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
      <h1 class="text-2xl font-bold tracking-tight text-white">
        {{ title }}
      </h1>

      <div class="flex items-center gap-3">

        <button @click="openModal"
          class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition-all duration-200 hover:bg-emerald-500 hover:shadow-lg hover:shadow-emerald-900/30 active:scale-95 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-900">
          <Plus class="h-4 w-4" />

          <span>{{ nameButton }}</span>
        </button>
        <slot />
      </div>
    </div>
  </header>
</template>
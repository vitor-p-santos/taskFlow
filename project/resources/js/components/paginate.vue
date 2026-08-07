<script setup lang="ts">
const props = defineProps<{
  prevUrl: string
  nextUrl: string
  borderPosition: 'top' | 'bottom'
}>()

const emit = defineEmits<{
  (e: 'handlePrevPage'): void
  (e: 'handleNextPage'): void
}>()

const prevButton = () => {
  emit('handlePrevPage')
}

const nextButton = () => {
  emit('handleNextPage')
}

const positionBorder = (position: 'top' | 'bottom') => {
  return position === 'top' ? 'mt-8 pt-4 border-t' : 'mb-8 pb-4 border-b'
}
</script>

<template>
  <nav
    class="flex justify-between items-center border-neutral-800"
    :class="positionBorder(props.borderPosition)"
  >
    <button @click="prevButton" :disabled="!prevUrl"
      class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
      ← Anterior
    </button>

    <button @click="nextButton" :disabled="!nextUrl"
      class="px-4 py-2 text-xs font-medium text-neutral-300 bg-neutral-800 rounded-xl hover:bg-neutral-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
      Próxima →
    </button>
  </nav>
</template>
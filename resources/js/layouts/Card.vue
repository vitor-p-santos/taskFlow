<script setup lang="ts">
const emit = defineEmits<{
  (e: 'click', event: MouseEvent): void
}>()

const handleClick = (event: MouseEvent) => {
  emit('click', event)
}
</script>

<template>
  <div @click="handleClick" class="group relative flex flex-col justify-between rounded-2xl bg-neutral-900 
            p-6 shadow-xl border border-neutral-800/80 transition-all duration-300
            hover:-translate-y-1 hover:border-emerald-500
           "> <!-- Animação removida daqui -->
    <slot />
  </div>
</template>
<script setup lang="ts">
import { Plus } from 'lucide-vue-next'

defineProps<{
  title: string
}>()

</script>

<template>
  <header class="sticky top-0 z-40 border-b border-neutral-800 bg-neutral-900/70 backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
      <h1 class="text-2xl font-bold tracking-tight text-white">
        <i>
          {{ title }}
        </i>
      </h1>

      <div class="flex items-center gap-3">
        <slot />
      </div>
    </div>
  </header>
</template>
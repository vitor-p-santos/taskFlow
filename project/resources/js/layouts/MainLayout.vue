<script setup lang="ts">
import { ref } from 'vue'
import Sidebar from './Sidebar.vue'

const isSidebarOpen = ref<boolean>(false)
</script>

<template>
  <div class="flex min-h-screen bg-[#121212] text-zinc-100">
    <!-- Sidebar fixa compartilhada -->
    <Sidebar v-model:is-open="isSidebarOpen" />

    <!-- Área principal que se adapta ao conteúdo -->
    <div class="flex-1 flex flex-col min-w-0">
      
      <!-- Slot opcional para o NavBar / Header específico de cada página -->
      <header v-if="$slots.header" class="border-b border-zinc-800">
        <slot name="header" />
      </header>

      <!-- Slot principal para o conteúdo da página -->
      <main class="flex-1 max-w-7xl w-full mx-auto px-4 py-6 space-y-6">
        <slot />
      </main>

    </div>
  </div>
</template>
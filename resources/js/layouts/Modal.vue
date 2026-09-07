<script setup lang="ts">
import { ref, watch } from 'vue';
import Loading from '../components/Loading.vue'

const modalRef = ref<HTMLDialogElement | null>(null);

const props = defineProps<{
  isOpen: boolean
  loading?: boolean
  title?: string
  description?: string
}>()

const emit = defineEmits<{
  (e: 'close'): void
}>()

const close = () => {
  if (props.loading) return
  emit('close')
}

watch(
  () => props.isOpen,
  (open) => {
    if (!modalRef.value) return

    if (open) {
      if (!modalRef.value.open) modalRef.value.showModal()
    } else {
      if (modalRef.value.open) modalRef.value.close()
    }
  },
  { immediate: true }
)
</script>

<template>
  <dialog
    ref="modalRef"
    @cancel.prevent="close"
    class="w-screen h-screen max-w-none max-h-none m-0 p-0 bg-neutral-900/50 border-none text-white backdrop-blur-xs transition-opacity focus:outline-none"
  >
    <div class="w-full h-full flex items-center justify-center p-6" @click="close">
      
      <div
        @click.stop
        class="w-full max-w-lg bg-neutral-900 p-8 rounded-2xl border border-neutral-800 flex flex-col gap-6 relative overflow-hidden"
      >
        
        <div v-if="loading" class="absolute inset-0 bg-neutral-900/80 rounded-2xl flex items-center justify-center z-10 backdrop-blur-xs">
          <Loading />
        </div>

        
        <header v-if="$slots.header || title" class="flex justify-between items-start">
          <slot name="header">
            <div>
              <h2 class="text-xl font-bold text-white">{{ title }}</h2>
              <p v-if="description" class="text-sm text-neutral-400 mt-1">{{ description }}</p>
            </div>
          </slot>
          
          <button
            type="button"
            aria-label="Fechar modal"
            @click="close"
            class="text-neutral-400 hover:text-white transition-colors"
          >
            ✕
          </button>
        </header>

        
        <div class="flex flex-col gap-4">
          <slot />
        </div>

        
        <footer v-if="$slots.footer" class="flex justify-end gap-3 pt-4 border-t border-neutral-800">
          <slot name="footer" />
        </footer>
      </div>

    </div>
  </dialog>
</template>
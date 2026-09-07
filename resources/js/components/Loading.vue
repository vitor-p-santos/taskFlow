<script setup lang="ts">
withDefaults(
  defineProps<{
    message?: string
    size?: '2sm' | 'sm' | 'md' | 'lg'
    fullScreen?: boolean
    inline?: boolean
  }>(),
  {
    message: 'Carregando...',
    size: 'md',
    fullScreen: false,
    inline: false
  }
)
</script>

<template>
  <div :class="[
    inline
      ? 'inline-flex items-center gap-2'
      : 'flex flex-col items-center justify-center gap-3',

    !inline && (
      fullScreen
        ? 'min-h-[60vh] w-full'
        : 'py-12 w-full'
    )
  ]">
    <div :class="[
      'animate-spin rounded-full border-neutral-700 border-t-emerald-500',
      size === '2sm' ? 'w-2 h-2 border-2' : '',
      size === 'sm' ? 'w-5 h-5 border-2' : '',
      size === 'md' ? 'w-8 h-8 border-3' : '',
      size === 'lg' ? 'w-12 h-12 border-4' : ''
    ]"></div>

    <p v-if="message" class="text-sm font-medium text-neutral-400 animate-pulse">
      {{ message }}
    </p>
  </div>
</template>
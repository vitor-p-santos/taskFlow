<script setup lang="ts">
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/AuthStore';
import { storeToRefs } from 'pinia';
import { ChevronRight, ChevronLeft, FolderInput, UserPen, LogOut } from 'lucide-vue-next';

const isOpen = defineModel<boolean>('isOpen', { default: false });

const router = useRouter();
const authStore = useAuthStore();

const toggleSidebar = () => {
  isOpen.value = !isOpen.value;
};

const navItem = [
  {
    name: 'Minha conta',
    path: '/settings',
    icon: UserPen,
  },
  {
    name: 'Projetos',
    path: '/projects',
    icon: FolderInput,
  },
];

const handleLogout = async () => {
  await authStore.logout();
  router.push('/');
};
</script>

<template>
  <button @click="toggleSidebar" :aria-expanded="isOpen" aria-controls="sidebar-menu"
    :aria-label="isOpen ? 'Recolher menu' : 'Expandir menu'" :title="isOpen ? 'Recolher menu' : 'Expandir menu'"
    class="fixed top-20 z-110 flex items-center justify-center p-1.5 rounded-full border border-emerald-300 bg-zinc-900 text-emerald-300 hover:text-emerald-500 hover:border-emerald-500 transition-all duration-300"
    :class="isOpen ? 'left-57' : 'left-2'">
    <component :is="isOpen ? ChevronLeft : ChevronRight" class="w-5 h-5" />
  </button>

  <aside id="sidebar-menu" aria-label="Barra lateral de navegação"
    class="fixed top-0 left-0 z-100 flex h-full w-60 flex-col justify-between bg-[#121212] border-r border-zinc-800 transition-transform duration-300 ease-in-out"
    :class="isOpen ? 'translate-x-0' : '-translate-x-full'">
    <div>
      <header class="p-4 border-b border-zinc-800">
        <h5 class="font-semibold text-zinc-100 truncate">{{ authStore.user?.name }}</h5>
        <p class="text-xs text-zinc-400 truncate">{{ authStore.user?.email }}</p>
      </header>

      <nav aria-label="Navegação principal" class="p-3">
        <ul class="space-y-1">
          <li v-for="item in navItem" :key="item.path">
            <RouterLink :to="item.path"
              class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-zinc-400 rounded-lg hover:bg-zinc-800/60 hover:text-zinc-100 transition-colors"
              active-class="bg-zinc-800 text-white">
              <component :is="item.icon" class="w-5 h-5 shrink-0" />
              <span>{{ item.name }}</span>
            </RouterLink>
          </li>
        </ul>
      </nav>
    </div>

    <footer class="p-3 border-t border-zinc-800">
      <button @click="handleLogout"
        class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium text-red-400 rounded-lg hover:bg-red-500/10 hover:text-red-300 transition-colors">
        <LogOut class="w-5 h-5 shrink-0" />
        <span>Sair</span>
      </button>
    </footer>
  </aside>
</template>
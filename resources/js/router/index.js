import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/AuthStore'

const AuthView = () => import('../views/Auth.vue')
const ProfileView = () => import('../views/Profile.vue')
const ProjectsView = () => import('../views/Projects.vue')
const ProjectDetails = () => import('../views/ProjectDetails.vue')

const routes = [
  { name: 'auth', path: '/', component: AuthView },
  { name: 'settings', path: '/settings', component: ProfileView, meta: { requiresAuth: true } },
  { name: 'projects', path: '/projects', component: ProjectsView, meta: { requiresAuth: true } },
  { name: 'tasks', path: '/projects/:id/tasks', component: ProjectDetails, meta: { requiresAuth: true } }
]

export const router = createRouter({
  history: createWebHistory(),
  routes
})

let isAppInitialized = false;

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();

  if (!authStore.user?.email && !isAppInitialized) {
    isAppInitialized = true;

    try {
      await authStore.fetchUser();
    } catch (err) {
      await authStore.logout(false);

      if (to.meta.requiresAuth) {
        return next({ name: 'auth' });
      }
    }
  }

  // Lógica de proteção de rotas normal
  if (to.meta.requiresAuth && !authStore.user) {
    return next({ name: 'auth' });
  }

  if (to.name === 'auth' && authStore.user) {
    return next({ name: 'projects' });
  }

  next();
});
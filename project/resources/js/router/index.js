import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/AuthStore'

const AuthView = () => import('../views/auth.vue')
const ProfileView = () => import('../views/Profile.vue')
const ProjectsView = () => import('../views/Projects.vue')
const ProjectDetails = () => import('../views/ProjectDetails.vue')

const routes = [
  { 
    name: 'login', 
    path: '/', 
    component: AuthView 
  },
  { 
    name: 'settings', 
    path: '/settings', 
    component: ProfileView,
    meta: { requiresAuth: true }
  },
  { 
    name: 'projects', 
    path: '/projects', 
    component: ProjectsView,
    meta: { requiresAuth: true }
  },
  { 
    name: 'tasks', 
    path: '/projects/:id/tasks', 
    component: ProjectDetails,
    meta: { requiresAuth: true }
  }
]

export const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();

  if (authStore.isAuthenticated && !authStore.user) {
    try {
      await authStore.fetchUser();
    } catch (err) {
      await authStore.logout();
    }
  }

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    return next({ name: 'login' });
  } 
  
  if (to.name === 'login' && authStore.isAuthenticated) {
    return next({ name: 'projects' });
  } 

  next();
});
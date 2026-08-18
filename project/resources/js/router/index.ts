import { createRouter, createWebHistory } from 'vue-router'
import ProjectsView from '../views/Projects.vue'
import ProjectDetails from '../views/ProjectDetails.vue'
import Auth from '../views/auth.vue'

const routes = [
  { path: '/', component: Auth },
  { path: '/projects', component: ProjectsView },
  { path: '/projects/:id/tasks', component: ProjectDetails, props: true }
]

export const router = createRouter({
  history: createWebHistory(),
  routes
})
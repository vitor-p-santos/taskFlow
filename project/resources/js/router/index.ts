import { createRouter, createWebHistory } from 'vue-router'
import ProjectsView from '../views/Home.vue'
import ProjectDetails from '../views/ProjectDetails.vue'

const routes = [
  { path: '/', component: ProjectsView },
  { path: '/projects/:id/tasks', component: ProjectDetails, props: true }
]

export const router = createRouter({
  history: createWebHistory(),
  routes
})
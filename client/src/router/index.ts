// import { Register } from '@/views/Register.vue'
// src/router/index.ts
import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import Login from '../views/Login.vue'
import Dashboard from '../views/Projects.vue'
import CreateProject from '../views/CreateProject.vue'
import ProjectDetails from '../views/ProjectDetails.vue'
import EndpointDetails from '../views/EndpointDetails.vue'
// import Register from '../views/Register.vue'

const routes: RouteRecordRaw[] = [
  { path: '/login', component: Login },
  { path: '/projects', component: Dashboard },
  { path: '/projects/:id', component: ProjectDetails },
  { path: '/projects/create', component: CreateProject },
  {
    path: '/projects/:projectId/endpoints/:endpointId',
    component: EndpointDetails
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router

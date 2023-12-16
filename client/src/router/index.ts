import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'

import Login from '../views/Login.vue'
import Dashboard from '../views/projects/Projects.vue'
import CreateProject from '../views/projects/CreateProject.vue'
import ProjectDetails from '../views/projects/ProjectDetails.vue'
import CreateEndpoint from '../views/endpoints/CreateEndpoint.vue'
import EndpointDetails from '../views/endpoints/EndpointDetails.vue'
import CreateEndpointField from '../views/endpoints/CreateEndpointField.vue'

const routes: RouteRecordRaw[] = [
  { path: '/login', component: Login },
  { path: '/projects', component: Dashboard },
  { path: '/projects/:projectId', name: 'ProjectDetails', component: ProjectDetails },
  { path: '/projects/create', component: CreateProject },
  {
    path: '/projects/:projectId/endpoints/:endpointId',
    component: EndpointDetails
  },
  {
    path: '/projects/:projectId/endpoints/:endpointId/field/create',
    name: 'CreateEndpointField',
    component: CreateEndpointField
  },
  {
    path: '/projects/:projectId/endpoints/create',
    component: CreateEndpoint
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router

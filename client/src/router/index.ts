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
  { path: '/apis', component: Dashboard },
  { path: '/apis/:projectId', name: 'ProjectDetails', component: ProjectDetails },
  { path: '/apis/create', component: CreateProject },
  {
    path: '/apis/:projectId/endpoints/:endpointId',
    component: EndpointDetails
  },
  {
    path: '/apis/:projectId/endpoints/:endpointId/field/create',
    name: 'CreateEndpointField',
    component: CreateEndpointField
  },
  {
    path: '/apis/:projectId/endpoints/create',
    component: CreateEndpoint
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router

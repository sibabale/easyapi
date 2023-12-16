<!-- ProjectDetails.vue -->
<template>
  <div>
    <div v-if="isLoadingProject">
      <p>Loading...</p>
    </div>
    <div v-else>
      <h2 class="text-lg font-semibold">{{ project.project.name }}</h2>
      <div>
        <small class="bg-lime-200 px-2 rounded-full text-lime-500">
          {{ project.project.api_type === 'Rest' ? 'REST' : project.project.api_type }}
        </small>
        <small class="ml-5 bg-purple-200 px-2 rounded-full text-purple-500">{{
          project.project.database
        }}</small>
      </div>
      <div>
        <small class="text-gray-400"
          >Created: {{ moment(project.project.created_at).format('LL') }}</small
        >
        <small class="ml-5 text-gray-400"
          >Updated: {{ moment(project.project.updated_at).endOf('day').fromNow() }}</small
        >
      </div>
      <empty-state
        v-if="project.project.endpoints <= 0"
        message="You have no endpoints for this project"
      />

      <div v-else class="my-5 rounded-lg border border-gray-200">
        <div class="p-4 flex items-center justify-between">
          <h2 class="text-xl font-bold">Endpoints</h2>
          <div class="flex items-center">
            <button
              :class="selectedEndpoints.length <= 0 ? 'opacity-0' : ''"
              class="p-2 mr-5 border border-red-500 flex items-center rounded text-red-500 text-sm"
              @click.prevent="deleteProjects"
            >
              <span class="material-symbols-outlined text-sm text-red-500"> delete </span>
              Delete
            </button>
            <button
              class="p-2 border border-blue-500 flex items-center rounded text-blue-500 text-sm"
              @click.prevent="navigateToCreateEndpoint"
            >
              <span class="material-symbols-outlined text-sm text-blue-500"> add </span>
              Add new endpoint
            </button>
          </div>
        </div>

        <div>
          <table class="min-w-full text-left">
            <thead>
              <tr class="border-y">
                <th class="py-2 px-4">
                  <input type="checkbox" disabled />
                </th>
                <th class="py-2 px-4">ID</th>
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Path</th>
                <th class="py-2 px-4">Method</th>
                <th class="py-2 px-4">Description</th>
                <!-- Add more columns as needed -->
              </tr>
            </thead>
            <tbody>
              <tr
                class="border-y last:border-b-0"
                v-for="endpoint in project.project.endpoints"
                :key="endpoint.id"
              >
                <td class="py-2 px-4">
                  <input type="checkbox" v-model="selectedEndpoints" :value="endpoint.id" />
                </td>
                <td class="py-2 px-4">{{ endpoint.id }}</td>

                <td class="py-2 px-4">
                  <router-link
                    class="underline text-blue-300"
                    :to="`/projects/${project.project.id}/endpoints/${endpoint.id}`"
                  >
                    {{ endpoint.name }}
                  </router-link>
                </td>
                <td class="py-2 px-4">
                  <div class="flex items-center">
                    <span class="mr-2">http://localhost:8000/api/{{ endpoint.name }}</span>
                  </div>
                </td>
                <td class="py-2 px-4">GET</td>
                <td class="py-2 px-4 w-1/3">
                  Fugiat earum minima nemo ipsa vel reprehenderit eaque occaecati sit.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import axios from 'axios'
import moment from 'moment'
import { useRoute, useRouter } from 'vue-router'
import { ref, onMounted } from 'vue'

import EmptyState from '../../components/EmptyState.vue'
import type { Project } from '../../types'

const route = useRoute()
const router = useRouter()

const project = ref<Project>(null)
const isLoadingProject = ref<boolean>(true)
const isLoading = ref<boolean>(false)
const selectedEndpoints = ref<number[]>([])
onMounted(() => fetchProjectDetails())

const navigateToCreateEndpoint = () =>
  router.push(`/projects/${route.params.projectId}/endpoints/create`)

const fetchProjectDetails = async (): Promise<void> => {
  isLoadingProject.value = true
  try {
    const response = await axios({
      url: `http://localhost:8000/api/projects/${route.params.projectId}`,
      method: 'GET',
      headers: {
        Authorization: `Bearer 6|HItUkQpazgDEoXyMnrABHVPMkcbQUnn57NhJqt4oaf34f8d2` // Assuming you store the token in localStorage
      }
    })
    project.value = response.data
    isLoadingProject.value = false
  } catch (error) {
    console.error('Error fetching project details:', error)
  }
}

const deleteProjects = () => {
  isLoading.value = true
  selectedEndpoints.value.map(async (endpoint: number): void => {
    try {
      await axios({
        url: `http://localhost:8000/api/endpoints/`,
        method: 'DELETE',
        headers: {
          Authorization: `Bearer 6|HItUkQpazgDEoXyMnrABHVPMkcbQUnn57NhJqt4oaf34f8d2`
        },
        data: {
          endpoint_id: endpoint
        }
      })
      fetchProjectDetails()
    } catch (error) {
      console.error('Error deleting project:', error)
    }
    isLoading.value = false
    selectedEndpoints.value = []
  })
}
</script>

<style>
/* Add your styling here */
</style>

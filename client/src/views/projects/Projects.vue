<template>
  <div>
    <div v-if="fetchingProjects">Loading...</div>
    <div v-else>
      <empty-state v-if="projects.length <= 0" message="You have no projects" />
      <div v-else class="my-5 rounded-lg border border-gray-200">
        <div class="p-4 flex items-center justify-between">
          <h2 class="text-xl font-bold">APIs</h2>
          <div class="flex items-center space-x-2">
            <div :class="selectedProjects.length <= 0 ? 'opacity-0' : ''">
              <button
                class="p-2 border border-red-500 flex items-center rounded text-red-500 text-sm"
                @click.prevent="deleteProjects"
              >
                <span class="material-symbols-outlined text-sm text-red-500"> delete </span>
                Delete
              </button>
            </div>
            <button
              class="p-2 border border-blue-500 flex items-center rounded text-blue-500 text-sm"
              @click.prevent="navigateToCreateAPI"
            >
              <span class="material-symbols-outlined text-sm text-blue-500"> add </span>
              Create New API
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
              </tr>
            </thead>
            <tbody>
              <tr class="border-y last:border-b-0" v-for="project in projects" :key="project.id">
                <td class="py-2 px-4">
                  <input
                    type="checkbox"
                    v-model="selectedProjects"
                    :value="project.id"
                    class="border-red-300"
                  />
                </td>
                <td class="py-2 px-4">{{ project.id }}</td>

                <td class="py-2 px-4">
                  <router-link class="underline text-blue-300" :to="`/apis/${project.id}`">
                    {{ project.name }}
                  </router-link>
                </td>
                <td class="py-2 px-4">
                  <div class="flex items-center">
                    <span class="mr-2"
                      >http://localhost:8000/api/v{{ project.api_version }}/{{
                        project.name.toLowerCase()
                      }}</span
                    >
                    <span class="material-symbols-outlined cursor-pointer"> content_copy </span>
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
import EmptyState from '../../components/EmptyState.vue'
import { useRouter } from 'vue-router'
import { ref, onMounted } from 'vue'
import type { Project } from '../../types'

const router = useRouter()
const projects = ref<Project[]>([])
const selectedProjects = ref<number[]>([])
const fetchingProjects = ref<boolean>(true)
const deletingProjects = ref<boolean>(true)

const navigateToCreateAPI = () => router.push(`/apis/create`)

const fetchProjects = async () => {
  try {
    const response = await axios({
      url: 'http://localhost:8000/api/projects',
      method: 'GET',
      headers: {
        Authorization: `Bearer 6|HItUkQpazgDEoXyMnrABHVPMkcbQUnn57NhJqt4oaf34f8d2` // Assuming you store the token in localStorage
      }
    })
    projects.value = response.data
    fetchingProjects.value = false
  } catch (error) {
    console.error('Error fetching projects:', error)
  }
}

const deleteProjects = () => {
  deletingProjects.value = true
  selectedProjects.value.map(async (project_id: number): void => {
    try {
      await axios({
        url: `http://localhost:8000/api/projects`,
        method: 'DELETE',
        headers: {
          Authorization: `Bearer 6|HItUkQpazgDEoXyMnrABHVPMkcbQUnn57NhJqt4oaf34f8d2`
        },
        data: {
          project_id
        }
      })
      fetchProjects()
    } catch (error) {
      console.error('Error deleting project:', error)
    }
    deletingProjects.value = false
    selectedProjects.value = []
  })
}

onMounted(() => {
  fetchProjects()
})
</script>

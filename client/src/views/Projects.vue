<template>
  <div>
    <div v-if="projects.length > 0">
      <h2 class="text-2xl mb-5 underline">Your Projects</h2>

      <div class="my-5 rounded-lg border border-gray-200">
        <div class="p-4 flex items-center justify-between">
          <h2 class="text-xl font-bold">Projects</h2>
          <div v-show="projects.length > 0">
            <button
              class="p-2 border border-red-500 flex items-center rounded text-red-500 text-sm"
              @click.prevent="deleteProjects"
            >
              <span class="material-symbols-outlined text-sm text-red-500"> delete </span>
              Delete
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
              <tr class="border-y last:border-b-0" v-for="project in projects" :key="project.id">
                <td class="py-2 px-4">
                  <input
                    type="checkbox"
                    v-model="selectedEndpoints"
                    :value="project.id"
                    class="border-red-300"
                    :disabled="isLoading"
                  />
                </td>
                <td class="py-2 px-4">{{ project.id }}</td>

                <td class="py-2 px-4">
                  <router-link class="underline text-blue-300" :to="`/projects/${project.id}`">
                    {{ project.name }}
                  </router-link>
                </td>
                <td class="py-2 px-4">
                  <div class="flex items-center">
                    <span class="mr-2"
                      >http://localhost:8000/api/{{ project.name.toLowerCase() }}</span
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
import { ref, onMounted } from 'vue'

const projects = ref([])
const newProjectName = ref('')

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
  } catch (error) {
    console.error('Error fetching projects:', error)
  }
}

const createProject = async () => {
  try {
    const response = await fetch('/api/projects', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer 6|HItUkQpazgDEoXyMnrABHVPMkcbQUnn57NhJqt4oaf34f8d2`
      },
      body: JSON.stringify({ name: newProjectName.value })
    })
    const data = await response.json()
    projects.value.push(data.project)
    newProjectName.value = '' // Clear input after successful creation
  } catch (error) {
    console.error('Error creating project:', error)
  }
}

onMounted(() => {
  fetchProjects()
})
</script>

<style scoped>
/* Add your component styles here */
</style>

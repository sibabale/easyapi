<template>
  <div>
    <div v-if="projects.length > 0">
      <h2 class="text-2xl mb-5 underline">Your Projects</h2>

      <div class="overflow-x-auto flex justify-center">
        <table class="w-10/12 border bg-white">
          <thead>
            <tr>
              <th class="py-2 px-4 text-left border-b">Name</th>
              <th class="py-2 px-4 text-left border-b">Description</th>
              <th class="py-2 px-4 text-left border-b">API Version</th>
              <th class="py-2 px-4 text-left border-b">Database</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="project in projects" :key="project.id">
              <td class="py-2 px-4 text-left border-b">{{ project.name }}</td>
              <td class="py-2 px-4 text-left border-b">{{ project.description }}</td>
              <td class="py-2 px-4 text-left border-b">{{ project.api_version }}</td>
              <td class="py-2 px-4 text-left border-b">{{ project.database }}</td>
            </tr>
          </tbody>
        </table>
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

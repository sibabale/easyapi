<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Create New Project</h1>

    <!-- Form for creating a new project -->
    <form @submit.prevent="submitForm" class="max-w-md mx-auto text-left">
      <!-- Project Name -->
      <div class="mb-4">
        <label for="projectName" class="block text-sm font-medium text-gray-700">
          Project Name
        </label>
        <input
          v-model="projectName"
          type="text"
          id="projectName"
          class="mt-1 p-2 border rounded w-full"
        />
      </div>

      <!-- Description -->
      <div class="mb-4">
        <label for="projectDescription" class="block text-sm font-medium text-gray-700">
          Description
        </label>
        <textarea
          v-model="projectDescription"
          id="projectDescription"
          class="mt-1 p-2 border rounded w-full"
        ></textarea>
      </div>

      <!-- API Version -->
      <div class="mb-4">
        <label for="apiVersion" class="block text-sm font-medium text-gray-700">
          API Version
        </label>
        <input
          v-model="apiVersion"
          type="number"
          id="apiVersion"
          class="mt-1 p-2 border rounded w-full"
        />
      </div>

      <!-- API Type -->
      <div class="mb-4">
        <label for="apiType" class="block text-sm font-medium text-gray-700"> API Type </label>
        <select v-model="apiType" id="apiType" class="mt-1 p-2 border rounded w-full">
          <option value="Rest">Rest</option>
          <option value="GraphQL">GraphQL</option>
        </select>
      </div>

      <!-- Database -->
      <div class="mb-4">
        <label for="database" class="block text-sm font-medium text-gray-700"> Database </label>
        <select v-model="database" id="database" class="mt-1 p-2 border rounded w-full">
          <option value="MySQL">MySQL</option>
          <!-- Add other database options as needed -->
        </select>
      </div>

      <!-- Submit Button -->
      <div class="mb-4">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
          Create Project
        </button>
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import axios from 'axios'
import { ref } from 'vue'
import createSlug from '../../utils/createSlug'
import { useRouter } from 'vue-router'

const router = useRouter()

const apiType = ref<string>('Rest')
const database = ref<string>('MySQL')
const apiVersion = ref<number>(1)
const projectName = ref<string>('')
const projectDescription = ref<string>('')

const submitForm = async (): void => {
  try {
    await axios({
      url: 'http://localhost:8000/api/projects',
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer 6|HItUkQpazgDEoXyMnrABHVPMkcbQUnn57NhJqt4oaf34f8d2`
      },
      data: JSON.stringify({
        name: createSlug(projectName.value, '-'),
        api_type: apiType.value,
        database: database.value,
        description: projectDescription.value,
        api_version: apiVersion.value
      })
    })

    setTimeout(() => router.push({ path: '/apis' }), 3000)
  } catch (error) {
    console.error('Error creating a project: ', error)
  }
}
</script>

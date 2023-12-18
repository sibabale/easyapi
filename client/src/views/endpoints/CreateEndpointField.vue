<template>
  <div>
    <h1 class="text-2xl font-bold mb-4 text-center">Create New Field</h1>

    <form @submit.prevent="submitForm" class="max-w-md mx-auto text-left">
      <label>New Field</label>
      <div class="flex mb-4 rounded items-center justify-between">
        <div class="w-1/2">
          <input
            id="fieldInput"
            type="text"
            v-model="newEndpointField.name"
            placeholder="Enter field name"
            class="p-2 w-full rounded-l border-y border-l focus:outline-none"
          />
        </div>
        <div class="w-2/5">
          <select
            v-model="newEndpointField.type"
            class="p-2 border-l w-full focus:outline-none border-y"
            placeholder="Enter field name"
          >
            <option value="" disabled selected>Select a type</option>

            <option value="Boolen">Boolean</option>
            <option value="Float">Float</option>
            <option value="Int">Integer</option>
            <option value="Text">Text</option>
            <option value="varchar(20)">Varchar(20)</option>
            <option value="varchar(255)">Varchar(255)</option>
          </select>
        </div>
        <input
          type="button"
          class="py-2 border border-blue-500 text-blue-500 px-4 rounded-r cursor-pointer"
          value="Save"
          @click.prevent="addNewEnpointField"
        />
      </div>

      <div class="my-5 rounded-lg border border-gray-200">
        <div class="p-4 flex items-center justify-between">
          <h2 class="text-md font-bold">Fields</h2>
          <button
            :class="selectedFields.length <= 0 ? 'opacity-0' : ''"
            class="p-2 border border-red-500 flex items-center rounded text-red-500 text-sm"
            @click.prevent="deleteProjects"
          >
            <span class="material-symbols-outlined text-sm text-red-500"> delete </span>
            Delete
          </button>
        </div>

        <div>
          <table class="min-w-full text-left">
            <thead>
              <tr class="border-y">
                <th class="py-2 px-4">
                  <input type="checkbox" disabled />
                </th>
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Type</th>
              </tr>
            </thead>
            <tbody>
              <tr
                class="border-y last:border-b-0"
                v-for="(field, index) in endpointFields"
                :key="index"
              >
                <td class="py-2 px-4">
                  <input
                    type="checkbox"
                    v-model="selectedFields"
                    :value="index"
                    class="border-red-300"
                  />
                </td>

                <td class="py-2 px-4">
                  {{ field.name }}
                </td>
                <td class="py-2 px-4">{{ field.type }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="mb-4 border-t">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-5 rounded">
          Create Endpoint
        </button>
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import axios from 'axios'
import slugify from 'slugify'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import type { Enpoint } from '../../types'

const route = useRoute()
const router = useRouter()

const selectedFields = ref<number[]>([])
const endpointFields = ref<Enpoint[]>([])
const newEndpointField = ref<Enpoint>({ name: '', type: null })

const submitForm = async (): void => {
  if (endpointFields.value.length > 0) {
    try {
      await axios({
        url: `http://localhost:8000/api/endpoints/fields`,
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Authorization: `Bearer 6|HItUkQpazgDEoXyMnrABHVPMkcbQUnn57NhJqt4oaf34f8d2`
        },
        data: JSON.stringify({
          fields: endpointFields.value,
          project_id: route.params.projectId,
          endpoint_id: route.params.endpointId
        })
      })
      router.push({
        name: 'EndpointDetails',
        params: {
          projectId: Number(route.params.projectId),
          endpointId: Number(route.params.endpointId)
        }
      })
    } catch (error) {
      console.error('Error creating a project: ', error)
    }
  } else {
    alert('Please enter both Field and Type before saving.')
  }
}
const addNewEnpointField = () => {
  // Check if both field and type are filled before saving
  if (newEndpointField.value.name && newEndpointField.value.type) {
    endpointFields.value.push({
      name: slugify(newEndpointField.value.name, {
        replacement: '_',
        lower: true,
        strict: true
      }),

      type: newEndpointField.value.type
    })

    // Reset input fields after saving
    newEndpointField.value.name = ''
    newEndpointField.value.type = null
  } else {
    alert('Please enter both Field and Type before saving.')
  }
}

// const addNewEnpointField = () => {
//   endpointFields.value.push(newEndpointField.value)
// }
</script>

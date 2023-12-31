<!-- ProjectDetails.vue -->
<template>
  <div>
    <div v-if="fetchingFields">
      <p>Loading...</p>
    </div>

    <empty-state v-if="endpointFields.length <= 0" message="You have no fields for this endpoint" />
    <div v-else class="my-5 rounded-lg border border-gray-200 shadow">
      <div class="p-4 flex items-center justify-between">
        <h2 class="text-xl font-bold">Endpoint Fields</h2>
        <div class="flex items-center">
          <button
            class="p-2 mr-5 border border-blue-500 flex items-center rounded text-blue-500 text-sm"
            @click.prevent="navigateToCreateEndpointField"
          >
            <span class="material-symbols-outlined text-sm text-blue-500"> add </span>
            Add new field
          </button>
          <button
            :class="selectedFields.length > 0 ? 'opacity-0' : ''"
            class="p-2 border border-red-500 flex items-center rounded text-red-500 text-sm"
            @click.prevent="deleteEndpointFields"
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
              <th class="py-2 px-4" v-for="field in endpointFields" :key="field.id">
                <div class="flex flex-col">
                  {{ separateAndCapitalize(field.field_attributes.name) }}
                  <small class="font-normal text-gray-400">{{ field.field_attributes.type }}</small>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="my-2 mx-4"></tr>
            <tr
              v-if="endpointFields.length > 0 && endpointValues.length <= 0"
              class="border-y last:border-b-0"
            >
              <td class="py-2 px-4" v-for="(item, index) in endpointFields" :key="index">
                No Value
              </td>
            </tr>
            <tr v-else class="border-y last:border-b-0">
              <td class="py-2 px-4" v-for="endpointValue in endpointValues" :key="endpointValue.id">
                {{ endpointValue.value ? endpointValue.value : 'No value' }}
              </td>
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
import { useRoute, useRouter } from 'vue-router'

import EmptyState from '../../components/EmptyState.vue'

const route = useRoute()
const router = useRouter()

const isLoading = ref<boolean>(false)
const endpointFields = ref([])
const endpointValues = ref<[]>([])
const selectedFields = ref<number[]>([])
const fetchingFields = ref<boolean>(true)

onMounted(() => {
  fetchEndpointFields()
  fetchEndpointValues()
})

const navigateToCreateEndpointField = () =>
  router.push({
    name: 'CreateEndpointField',
    params: { projectId: route.params.projectId, endpointId: route.params.endpointId }
  })

let leadFieldId = Math.min(
  ...endpointValues.value.map((item) => {
    return item.field_id
  })
)

// Custom sorting function
const customSort = (a, b) => {
  if (a.field_id === leadFieldId) {
    return -1 // a comes first
  } else if (b.field_id === leadFieldId) {
    return 1 // b comes first
  } else {
    return a.field_id - b.field_id // Sort by field_id
  }
}

const fetchEndpointFields = async (): Promise<void> => {
  try {
    const response = await axios({
      url: 'http://localhost:8000/api/endpoints/fields',
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer 6|HItUkQpazgDEoXyMnrABHVPMkcbQUnn57NhJqt4oaf34f8d2`
      },
      params: {
        endpoint_id: route.params.endpointId
      }
    })
    endpointFields.value = response.data
    fetchingFields.value = false
  } catch (error) {
    console.error('Error fetching endpoint fields:', error.response.data)
  }
}

const fetchEndpointValues = async (): Promise<void> => {
  try {
    const response = await axios({
      url: 'http://localhost:8000/api/endpoints/fields/values',
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer 6|HItUkQpazgDEoXyMnrABHVPMkcbQUnn57NhJqt4oaf34f8d2`
      },
      params: {
        endpoint_id: route.params.endpointId
      }
    })

    // Finding field_id with the smallest value and setting it as the first item in array
    leadFieldId = Math.min(
      ...response.data.map((item) => {
        return item.field_id
      })
    )

    // Sorting the response data using the leadFieldId
    endpointValues.value = response.data.sort(customSort)
  } catch (error) {
    console.error('Error fetching endpoint fields:', error.response.data)
  }
}

const deleteEndpointFields = () => {
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

function separateAndCapitalize(str) {
  // Split the string by underscores
  const words = str.split('_')

  // Capitalize each word
  const capitalizedWords = words.map((word) => word.charAt(0).toUpperCase() + word.slice(1))

  // Join the words back together
  const result = capitalizedWords.join(' ')

  return result
}
</script>

<style>
/* Add your styling here */
</style>

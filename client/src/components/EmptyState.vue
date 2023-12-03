<template>
  <div class="p-5 my-5 border border-dashed rounded-lg text-center">
    {{ props.message }}
  </div>
</template>

<script lang="ts" setup>
import { defineProps } from 'vue'

const props = defineProps<{ message: string }>()
</script>

<template>
  <div class="p-5 my-5 border border-dashed rounded-lg text-center">
    {{ props.message }}
    <div class="mt-5 flex justify-center">
      <slot />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { defineProps } from 'vue'

const props = defineProps<{ message: string }>()
</script>

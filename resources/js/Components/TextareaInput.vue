<script setup lang="ts">
export interface Props {
  rows?: string
}

const props = withDefaults(defineProps<Props>(), {
  rows: 4
})

const model = defineModel<string>({ required: true });
</script>

<template>
  <textarea 
    v-model="model" 
    :rows="rows"
    class="block p-2.5 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
  />
</template>

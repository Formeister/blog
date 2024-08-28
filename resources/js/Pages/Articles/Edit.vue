<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ArticleForm from "@/Pages/Articles/Partials/ArticleForm.vue";
import {Head} from "@inertiajs/vue3";

const props = defineProps<{
    article: Object
}>();
</script>

<template>
  <Head title="Edit Article" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Article</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <ArticleForm :article="article" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

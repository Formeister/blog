<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ArticleForm from "@/Pages/Articles/Partials/ArticleForm.vue";
import {Head} from "@inertiajs/vue3";
</script>

<template>
  <Head title="New Article" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">New Article</h2>
    </template>
    <ArticleForm />
  </AppLayout>
</template>

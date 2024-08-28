<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {Head, router} from "@inertiajs/vue3";
import {computed} from 'vue';
import {truncateText} from '@composables/textUtilities';

const props = defineProps<{
  articles: Object
}>();

const hasNextPage = computed(() => props.articles.current_page < props.articles.last_page);
const hasPreviousPage = computed(() => props.articles.current_page > 1);

const navigateToPage = (page: number) => {
  router.get(
      route('articles.index'),
      {
        limit: props.articles.per_page,
        offset: (page - 1) * props.articles.per_page,
      },
      {
        only: ['articles'],
      }
  );
};

const onNextPageButtonClick = () => {
  if (hasNextPage.value) {
    navigateToPage(props.articles.current_page + 1);
  }
};

const onPreviousPageButtonClick = () => {
  if (hasPreviousPage.value) {
    navigateToPage(props.articles.current_page - 1);
  }
};
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Articles
      </h2>
    </template>
    <div class="pt-6 pb-3">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <SecondaryButton
            type="button"
            @click="router.visit(route('articles.create'))"
        >
          New Article
        </SecondaryButton>
      </div>
    </div>
    <template v-if="articles.data.length > 0">
      <div v-for="article in articles.data"
           :key="article.slug"
           class="py-3"
      >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <h2 class="text-xl">{{ article.title }}</h2>
              <p>{{ truncateText(article.description, 100) }}</p>
              <div class="mt-4">
                <SecondaryButton
                    type="button"
                    @click="router.visit(route('articles.show', article.slug))"
                >
                  Read more
                </SecondaryButton>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="pt-3 pb-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <SecondaryButton
              class="me-3"
              :disabled="!hasPreviousPage"
              type="button"
              @click="onPreviousPageButtonClick"
          >
            Previous
          </SecondaryButton>
          <SecondaryButton
              :disabled="!hasNextPage"
              type="button"
              @click="onNextPageButtonClick"
          >
            Next
          </SecondaryButton>
        </div>
      </div>
    </template>
    <div
        v-else
        class="py-3"
    >
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <p>No articles available.</p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

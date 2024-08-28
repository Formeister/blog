<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CommentCreateForm from "@/Pages/Articles/Partials/CommentCreateForm.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import axios from "axios";
import {Head, Link, router, usePage} from "@inertiajs/vue3";
import {computed, onMounted, ref} from 'vue';

const page = usePage();

const props = defineProps<{
  article: Object
}>();

const comments = ref([]);
const isAuthenticated = computed(() => page.props.auth.user !== null);

const fetchArticleComments = async () => {
  try {
    const url = route('api.articles.comments.index', props.article.slug);
    const response = await axios.get(url);
    comments.value = response.data.comments;
  } catch (error) {
    console.error("Error fetching comments:", error);
  }
};

const onCommentAdded = (newComment) => {
  comments.value.push(newComment);
};

const onArticleDeleteButtonClick = () => {
  if (confirm('Are you sure you want to delete this article?')) {
    router.delete(route('articles.destroy', props.article.slug), {
      onSuccess: () => {
        router.visit(route('articles.index'));
      },
    });
  }
};

onMounted(async () => {
  if (isAuthenticated.value) {
    await fetchArticleComments();
  }
});
</script>

<template>
  <Head title="Article" />
  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Articles
      </h2>
    </template>
    <div
        v-if="isAuthenticated"
        class="pt-6"
    >
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <DangerButton
            class="me-3"
            type="button"
            @click="onArticleDeleteButtonClick"
        >
          Delete
        </DangerButton>
        <SecondaryButton
            type="button"
            @click="router.visit(route('articles.edit', article.slug))"
        >
          Edit
        </SecondaryButton>
      </div>
    </div>
    <div class="pt-6 pb-3">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <h1 class="text-xl">{{ article.title }}</h1>
            <p class="article-meta">Published on {{ article.createdAt }}</p>
            <p class="article-description">{{ article.description }}</p>
            <div class="article-body" v-html="article.body"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-3">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg">Comments</h2>
            <template v-if="isAuthenticated">
              <template v-if="isAuthenticated">
                <template v-if="comments.length">
                  <!-- List of Comments -->
                  <div v-for="comment in comments" class="comment">
                    <p>{{ comment.body }}</p>
                    <small>— {{ comment.createdAt }}</small>
                  </div>
                </template>
                <CommentCreateForm
                    class="mt-4"
                    :article="article"
                    @comment-added="onCommentAdded"
                />
              </template>
            </template>
            <template v-else>
              <p>
                Please
                <Link :href="route('login')" as="button" type="button">login</Link>
                to view comments.
              </p>
            </template>
          </div>
        </div>
      </div>
    </div>
    <div class="pt-3 pb-10">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <SecondaryButton
            class="me-3"
            type="button"
            @click="router.visit(route('articles.index'))"
        >
          Back to Articles
        </SecondaryButton>
      </div>
    </div>
  </AppLayout>
</template>

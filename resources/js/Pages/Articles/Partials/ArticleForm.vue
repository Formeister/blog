<script lang="ts" setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import {computed} from 'vue';
import {router, useForm} from "@inertiajs/vue3";

const props = defineProps<{
  article?: Object
}>();

const isEditing = computed(() => !!props.article?.slug);
const cancelRoute = computed(() => isEditing.value ? route('articles.show', props.article.slug) : route('articles.index'));
const form = useForm({
  title: props.article?.title || '',
  description: props.article?.description || '',
  body: props.article?.body || '',
});

const onFormSubmit = () => {
  if (isEditing.value) {
    form.put(route('articles.update', props.article.slug));
  } else {
    form.post(route('articles.store'));
  }
};

const onCancelButtonClick = () => {
  router.visit(cancelRoute.value);
};
</script>

<template>
  <div class="article-form">
    <form @submit.prevent="onFormSubmit" class="mt-6 space-y-6">
      <div
          v-if="form.errors.slug"
          class="error"
      >
        {{ form.errors.slug }}
      </div>
      <div>
        <InputLabel for="title" value="Title" />

        <TextInput
            id="title"
            type="text"
            class="mt-1 block w-full"
            v-model="form.title"
            required
            autofocus
            autocomplete="title"
        />
        <InputError class="mt-2" :message="form.errors.title" />
      </div>
      <div>
        <InputLabel for="description" value="Description" />
        <TextareaInput
            id="description"
            v-model="form.description"
        />
        <InputError class="mt-2" :message="form.errors.description" />
      </div>
      <div>
        <InputLabel for="body" value="Body" />
        <TextareaInput
            id="body"
            v-model="form.body"
        />
        <InputError class="mt-2" :message="form.errors.body" />
      </div>

      <div class="flex items-center gap-4">
        <SecondaryButton :disabled="form.processing" type="button" @click="onCancelButtonClick">Cancel</SecondaryButton>
        <PrimaryButton :disabled="form.processing" type="submit">
          {{ isEditing ? 'Update Article' : 'Create Article' }}
        </PrimaryButton>
      </div>
    </form>
  </div>
</template>

<style scoped>
.article-form {
  max-width: 600px;
  margin: 0 auto;
}

.error {
  color: red;
  font-size: 0.9em;
}
</style>

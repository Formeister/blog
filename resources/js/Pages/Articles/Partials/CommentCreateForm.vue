<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import axios from 'axios'
import {ref} from 'vue';

const props = defineProps<{
    article: Object
}>();

const emit = defineEmits(['comment-added']); // Define emit for the custom event

const form = ref({
    body: '',
    errors: {},
    processing: false,
});

const onFormSubmit = async () => {
    form.value.processing = true;
    form.value.errors = {}; // Reset errors before submission

    try {
        const response = await axios.post(route('api.articles.comments.store', props.article.slug), {
            body: form.value.body,
        });

        emit('comment-added', response.data.comment);

        form.value.body = '';
    } catch (error) {
        if (error.response && error.response.data.errors) {
           form.value.errors.body = error.response.data.errors.body ? error.response.data.errors.body[0] : '';
        }
    } finally {
        form.value.processing = false;
    }
};
</script>

<template>
  <form @submit.prevent="onFormSubmit">
    <InputLabel for="body" value="Body" />
    <TextareaInput
        v-model="form.body"
        id="body"
        rows="2"
    />
    <InputError class="mt-2" :message="form.errors.body" />
    <PrimaryButton
        class="mt-4"
        :disabled="form.processing"
        type="submit"
    >
      Submit
    </PrimaryButton>
  </form>
</template>

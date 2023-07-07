<template>
    <h1>Update series "{{ series.name }}"</h1>

    <form @submit.prevent="form.put(route('admin.series.update', [series]))" class="m-t-5">
        <div class="m-b-4">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="form.name" required>
        </div>

        <div class="m-b-4">
            <label for="background_colour" class="form-label">Background color</label>
            <input type="color" id="background_colour" v-model="form.background_colour">
        </div>

        <div class="m-b-4">
            <label for="text_colour" class="form-label">Text color</label>
            <input type="color" id="text_colour" v-model="form.text_colour">
        </div>

        <button type="submit" class="btn btn-primary">Update series</button>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Series from '@/Interfaces/Series/DetailedSeries';

interface Props {
    series: Series;
}

interface Form {
    name: string,
    background_colour: string,
    text_colour: string,
}

const props = defineProps<Props>();

const form = useForm<Form>({
    name: props.series.name,
    background_colour: props.series.background_colour,
    text_colour: props.series.text_colour,
});
</script>

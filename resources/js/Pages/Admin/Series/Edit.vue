<template>
    <h2>Update series "{{ series.name }}"</h2>

    <form @submit.prevent="form.put(route('admin.series.update', [series]))">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="form.name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="background_colour" class="form-label">Background color</label>
            <input type="color" id="background_colour" v-model="form.background_colour"
                   class="form-control form-control-color"
            >
        </div>

        <div class="mb-3">
            <label for="text_colour" class="form-label">Text color</label>
            <input type="color" id="text_colour" v-model="form.text_colour" class="form-control form-control-color">
        </div>

        <button type="submit" class="btn btn-primary">Update series</button>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    series: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.series.name,
    background_colour: props.series.background_colour,
    text_colour: props.series.text_colour,
});
</script>

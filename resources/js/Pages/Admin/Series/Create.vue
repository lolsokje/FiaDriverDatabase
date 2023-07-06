<template>
    <h2>Add series</h2>

    <form @submit.prevent="form.post(route('admin.series.store'))">
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

        <button type="submit" class="btn btn-primary">Add series</button>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    background_colour: '#000000',
    text_colour: '#FFFFFF',
});
</script>

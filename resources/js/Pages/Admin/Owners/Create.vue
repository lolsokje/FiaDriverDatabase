<template>
    <h2>Add owner</h2>

    <form @submit.prevent="form.post(route('admin.owners.store'))">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="form.name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add owner</button>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

interface Form {
    name: string,
}

const form = useForm<Form>({
    name: '',
});
</script>

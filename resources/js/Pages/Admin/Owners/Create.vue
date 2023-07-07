<template>
    <h1>Add owner</h1>

    <form @submit.prevent="form.post(route('admin.owners.store'))" class="m-t-5">
        <div class="m-b-4">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="form.name" required>
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

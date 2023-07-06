<template>
    <h2>Update owner</h2>

    <form @submit.prevent="form.put(route('admin.owners.update', [owner]))">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="form.name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update owner</button>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    owner: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.owner.name,
});
</script>

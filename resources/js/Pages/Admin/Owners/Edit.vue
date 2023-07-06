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

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import BaseOwner from '@/Interfaces/Owners/BaseOwner';

interface Props {
    owner: BaseOwner,
}

interface Form {
    name: string,
}

const props = defineProps<Props>();

const form = useForm<Form>({
    name: props.owner.name,
});
</script>

<template>
    <h1>Update owner</h1>

    <form @submit.prevent="form.put(route('admin.owners.update', [owner]))" class="m-t-5">
        <div class="m-b-4">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="form.name" required>
        </div>

        <button type="submit" class="btn btn-primary">Update owner</button>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import BaseOwner from '@/Interfaces/Owners/BaseOwner';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';

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

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Owners', route('admin.owners.index')),
    new Breadcrumb(props.owner.name),
    new Breadcrumb('Edit'),
];
</script>

<template>
    <div class="container">
        <h1 class="m-b-4">Add series</h1>

        <Users/>
    </div>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import Users from '@/Forms/Admin/Users.vue';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';

interface Form {
    username: string,
    discord_id: string,
}

const form = useForm<Form>({
    username: '',
    discord_id: '',
});

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Users', route('admin.users.index')),
    new Breadcrumb('Create'),
];
</script>

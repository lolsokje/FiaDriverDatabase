<template>
    <div class="container">
        <h1 class="m-b-4">Add driver</h1>

        <Drivers :users="users"/>
    </div>
</template>

<script lang="ts" setup>
import User from '@/Contracts/User';
import Drivers from '@/Forms/Admin/Drivers.vue';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';

interface Props {
    users: User[],
}

defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Drivers', route('admin.drivers.index')),
    new Breadcrumb('Create'),
];
</script>

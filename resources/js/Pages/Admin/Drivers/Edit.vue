<template>
    <div class="container">
        <h1>Edit driver</h1>

        <Drivers :driver="driver" :users="users"/>
    </div>
</template>

<script lang="ts" setup>
import Drivers from '@/Forms/Admin/Drivers.vue';
import Driver from '@/Contracts/Driver';
import User from '@/Contracts/User';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import route from 'ziggy-js';

interface Props {
    driver: Driver,
    users: User[],
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Drivers', route('admin.drivers.index')),
    new Breadcrumb(props.driver.full_name),
    new Breadcrumb('Edit'),
];
</script>

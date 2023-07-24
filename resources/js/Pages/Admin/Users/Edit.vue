<template>
    <div class="container">
        <h1>Edit user</h1>

        <Users :user="user"/>
    </div>
</template>

<script lang="ts" setup>
import User from '@/Contracts/User';
import Users from '@/Forms/Admin/Users.vue';
import Breadcrumb from '@/Entities/Breadcrumb';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import route from 'ziggy-js';

interface Props {
    user: User,
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Users', route('admin.users.index')),
    new Breadcrumb(props.user.username),
    new Breadcrumb('Edit'),
];
</script>

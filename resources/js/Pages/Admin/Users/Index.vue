<template>
    <div class="container">
        <h1>Users</h1>

        <InertiaLink :href="route('admin.users.create')" class="btn btn-primary m-y-4">Add user</InertiaLink>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Discord ID</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.username }}</td>
                    <td>{{ user.discord_id }}</td>
                    <td>
                        <InertiaLink :href="route('admin.users.edit', user)">edit</InertiaLink>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script lang="ts" setup>
import User from '@/Contracts/User';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';

interface Props {
    users: User[],
}

defineProps<Props>();

breadcrumbStore.breadcrumbs = [];
</script>

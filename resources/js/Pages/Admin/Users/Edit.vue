<template>
    <div class="container">
        <h1>Edit user</h1>

        <Users :user="user"/>
    </div>
</template>

<script lang="ts" setup>
import User from '@/Contracts/User';
import Users from '@/Forms/Admin/Users.vue';

interface Props {
    user: User,
}

defineProps<Props>();
</script>

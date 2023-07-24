<template>
    <div class="container">
        <h1 class="m-b-4">Add driver</h1>

        <Drivers :users="users"/>
    </div>
</template>

<script lang="ts" setup>
import User from '@/Contracts/User';
import Drivers from '@/Forms/Admin/Drivers.vue';

interface Props {
    users: User[],
}

defineProps<Props>();
</script>

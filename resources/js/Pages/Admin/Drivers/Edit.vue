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

interface Props {
    driver: Driver,
    users: User[],
}

defineProps<Props>();
</script>

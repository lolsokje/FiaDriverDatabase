<template>
    <div class="container">
        <h1 class="m-b-4">Add series</h1>

        <Users/>
    </div>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import Users from '@/Forms/Admin/Users.vue';

interface Form {
    username: string,
    discord_id: string,
}

const form = useForm<Form>({
    username: '',
    discord_id: '',
});
</script>

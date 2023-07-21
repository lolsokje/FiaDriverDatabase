<template>
    <MainNavigation :user="user"/>
</template>

<script lang="ts" setup>
import MainNavigation from '@/Components/Navigation/MainNavigation.vue';
import { usePage } from '@inertiajs/vue3';
import { computed, ComputedRef } from 'vue';
import User from '@/Contracts/User';

const page = usePage();

const user: ComputedRef<User | null> = computed(() => page.props.user as User | null);
</script>

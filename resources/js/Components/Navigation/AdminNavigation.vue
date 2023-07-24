<template>
    <nav class="main-nav">
        <div class="links centered">
            <InertiaLink :href="route('admin.series.index')" :class="{ 'active': isActive('series') }">
                <span>Series</span>
            </InertiaLink>
            <InertiaLink :href="route('admin.users.index')" :class="{ 'active': isActive('users') }">
                <span>Users</span>
            </InertiaLink>
            <InertiaLink :href="route('admin.drivers.index')" :class="{ 'active': isActive('drivers') }">
                <span>Drivers</span>
            </InertiaLink>
        </div>
    </nav>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import { computed, ComputedRef } from 'vue';

const page = usePage();

const currentRoute: ComputedRef<string> = computed(() => page.props.activeRoute as string);

const isActive = (routeToCheck: string): boolean => {
    return currentRoute.value.includes(routeToCheck);
};
</script>

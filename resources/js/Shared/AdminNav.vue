<template>
    <nav class="main-nav">
        <div class="links">
            <InertiaLink :href="route('admin.series.index')" :class="{ 'active': isActive('series') }">
                <span>Series</span>
            </InertiaLink>
            <InertiaLink :href="route('admin.owners.index')" :class="{ 'active': isActive('owners') }">
                <span>Owners</span>
            </InertiaLink>
            <InertiaLink :href="route('admin.teams.index')" :class="{ 'active': isActive('teams') }">
                <span>Teams</span>
            </InertiaLink>
            <InertiaLink :href="route('admin.drivers.index')" :class="{ 'active': isActive('drivers') }">
                <span>Drivers</span>
            </InertiaLink>
            <InertiaLink :href="route('admin.settings.show')" :class="{ 'active': isActive('settings') }">
                <span>Settings</span>
            </InertiaLink>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, ComputedRef } from 'vue';

const page = usePage();

const currentRoute: ComputedRef<string> = computed(() => page.props.activeRoute as string);

const isActive = (routeToCheck: string): boolean => {
    return currentRoute.value.includes(routeToCheck);
};
</script>

<script lang="ts">
export default { name: 'AdminNav' };
</script>

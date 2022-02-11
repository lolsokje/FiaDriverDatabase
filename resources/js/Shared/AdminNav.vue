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
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
               data-bs-toggle="dropdown">
                Development
            </a>
            <ul class="dropdown-menu">
                <li>
                    <InertiaLink :href="route('admin.development.show')" class="dropdown-item">
                        Setup
                    </InertiaLink>
                </li>
                <li>
                    <InertiaLink href="#" class="dropdown-item">Overview</InertiaLink>
                </li>
                <li>
                    <InertiaLink href="#" class="dropdown-item">Perform dev</InertiaLink>
                </li>
            </ul>
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
               data-bs-toggle="dropdown">
                Development
            </a>
            <ul class="dropdown-menu">
                <li>
                    <InertiaLink :href="route('admin.development.show')" class="dropdown-item">
                        Setup
                    </InertiaLink>
                </li>
                <li>
                    <InertiaLink :href="route('admin.development.index')" class="dropdown-item">
                        Overview
                    </InertiaLink>
                </li>
                <li>
                    <InertiaLink href="#" class="dropdown-item">Perform dev</InertiaLink>
                </li>
            </ul>
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

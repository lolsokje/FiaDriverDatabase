<template>
    <AdminNavigation/>

    <div class="container px-4 sm:px-0">
        <Breadcrumbs/>
    </div>

    <slot/>
</template>

<script lang="ts" setup>
import AdminNavigation from '@/Components/Navigation/AdminNavigation.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
</script>

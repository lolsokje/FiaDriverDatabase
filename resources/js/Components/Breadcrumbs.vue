<template>
    <nav class="m-b-5 breadcrumbs" v-if="breadcrumbStore.breadcrumbs.length">
        <ul v-for="(crumb, index) in breadcrumbStore.breadcrumbs" :key="index">
            <li class="breadcrumb-item">
                <InertiaLink :href="crumb.link" v-if="crumb.link">{{ crumb.text }}</InertiaLink>
                <span class="breadcrumb-label" v-else>{{ crumb.text }}</span>
                <span v-if="index !== breadcrumbStore.breadcrumbs.length - 1" class="m-l-3 m-r-3">/</span>
            </li>
        </ul>
    </nav>
</template>

<script lang="ts" setup>
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
</script>

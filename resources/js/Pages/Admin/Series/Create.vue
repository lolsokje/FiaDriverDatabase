<template>
    <div class="container">
        <h1 class="m-b-4">Add series</h1>

        <Series/>
    </div>
</template>

<script lang="ts" setup>
import Series from '@/Forms/Admin/Series.vue';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Series', route('admin.series.index')),
    new Breadcrumb('Add series'),
];
</script>

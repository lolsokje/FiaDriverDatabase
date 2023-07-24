<template>
    <div class="container">
        <h1 class="m-b-4">Edit series</h1>

        <Series :series="series"/>
    </div>
</template>

<script lang="ts" setup>
import Series from '@/Forms/Admin/Series.vue';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';

interface Props {
    series: Series,
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Series', route('admin.series.index')),
    new Breadcrumb(props.series.name),
    new Breadcrumb('Edit'),
];
</script>

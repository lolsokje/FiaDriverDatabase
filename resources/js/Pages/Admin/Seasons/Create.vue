<template>
    <div class="container">
        <h1 class="m-b-4">Add season</h1>

        <Seasons :series="series"/>
    </div>
</template>

<script lang="ts" setup>
import Series from '@/Contracts/Series';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import route from 'ziggy-js';
import Seasons from '@/Forms/Admin/Seasons.vue';

interface Props {
    series: Series,
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Series', route('admin.series.index')),
    new Breadcrumb(props.series.name, route('admin.series.index', props.series)),
    new Breadcrumb('Seasons', route('admin.seasons.index', props.series)),
    new Breadcrumb('Create'),
];
</script>

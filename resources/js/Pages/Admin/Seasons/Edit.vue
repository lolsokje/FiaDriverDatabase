<template>
    <div class="container">
        <h1 class="m-b-4">Edit season</h1>

        <Seasons :series="series" :season="season"/>
    </div>
</template>

<script lang="ts" setup>
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import Series from '@/Contracts/Series';
import Season from '@/Contracts/Season';
import Seasons from '@/Forms/Admin/Seasons.vue';

interface Props {
    series: Series,
    season: Season,
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Series', route('admin.series.index')),
    new Breadcrumb(props.series.name, route('admin.series.index', props.series)),
    new Breadcrumb('Seasons', route('admin.seasons.index', props.series)),
    new Breadcrumb(props.season.year.toString()),
    new Breadcrumb('Edit'),
];
</script>

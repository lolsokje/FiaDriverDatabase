<template>
    <div class="container">
        <h1>Seasons</h1>

        <InertiaLink :href="route('admin.seasons.create', series)" class="btn btn-primary m-y-4">
            Add season
        </InertiaLink>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>Year</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="season in seasons" :key="season.id">
                    <td>{{ season.year }}</td>
                    <td class="centered small">
                        <InertiaLink :href="route('admin.seasons.edit', [series, season])">
                            edit
                        </InertiaLink>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Series from '@/Contracts/Series';
import Season from '@/Contracts/Season';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import route from 'ziggy-js';

interface Props {
    series: Series,
    seasons: Season[],
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Series', route('admin.series.index')),
    new Breadcrumb(props.series.name, route('admin.series.index', props.series)),
    new Breadcrumb('Seasons'),
];
</script>

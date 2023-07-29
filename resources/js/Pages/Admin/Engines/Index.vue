<template>
    <div class="container">
        <h1>Teams</h1>

        <InertiaLink :href="route('admin.engines.create', series)" class="btn btn-primary m-y-4">
            Add engine
        </InertiaLink>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="engine in engines" :key="engine.id">
                    <td>{{ engine.name }}</td>
                    <td class="centered small">
                        <InertiaLink :href="route('admin.engines.edit', [series, engine])">edit</InertiaLink>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Series from '@/Contracts/Series';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import route from 'ziggy-js';
import Engine from '@/Contracts/Engine';

interface Props {
    series: Series,
    engines: Engine[],
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Series', route('admin.series.index')),
    new Breadcrumb(props.series.name),
    new Breadcrumb('Engines'),
];
</script>

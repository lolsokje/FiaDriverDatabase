<template>
    <h1>Series</h1>

    <InertiaLink :href="route('admin.series.create')" class="btn btn-primary m-y-4">Add series</InertiaLink>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in series" :key="item.id">
                <td>{{ item.name }}</td>
                <td class="centered small">
                    <InertiaLink :href="route('admin.series.edit', [item])">edit</InertiaLink>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import BaseSeries from '@/Interfaces/Series/BaseSeries';
import route from 'ziggy-js';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';

interface Props {
    series: BaseSeries[],
}

defineProps<Props>();

breadcrumbStore.breadcrumbs = [];
</script>

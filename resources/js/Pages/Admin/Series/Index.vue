<template>
    <div class="container">
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
                <tr v-for="s in series" :key="s.id">
                    <td>{{ s.name }}</td>
                    <td class="centered small">
                        <InertiaLink :href="route('admin.series.edit', s)">edit</InertiaLink>
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

interface Props {
    series: Series[],
}

defineProps<Props>();

breadcrumbStore.breadcrumbs = [];
</script>

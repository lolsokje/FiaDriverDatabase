<template>
    <h2>Series</h2>

    <InertiaLink :href="route('admin.series.create')" class="btn btn-primary my-3">Add series</InertiaLink>

    <table class="table table-bordered table-dark">
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
</template>

<script setup lang="ts">
import Series from '@/Interfaces/Series';

interface Props {
    series: Series[],
}

defineProps<Props>();
</script>

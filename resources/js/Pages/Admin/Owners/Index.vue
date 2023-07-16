<template>
    <h1>Owners</h1>

    <InertiaLink :href="route('admin.owners.create')" class="btn btn-primary m-y-4">Add owner</InertiaLink>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="owner in owners" :key="owner.id">
                <td>{{ owner.name }}</td>
                <td class="centered small">
                    <InertiaLink :href="route('admin.owners.edit', [owner])">edit</InertiaLink>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import BaseOwner from '@/Interfaces/Owners/BaseOwner';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';

interface Props {
    owners: BaseOwner[],
}

defineProps<Props>();

breadcrumbStore.breadcrumbs = [];
</script>

<template>
    <h1>Owners</h1>

    <InertiaLink :href="route('admin.owners.create')" class="btn btn-primary m-y-4">Add owner</InertiaLink>

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
</template>

<script setup lang="ts">
import BaseOwner from '@/Interfaces/Owners/BaseOwner';

interface Props {
    owners: BaseOwner[],
}

defineProps<Props>();
</script>

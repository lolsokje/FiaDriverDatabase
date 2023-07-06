<template>
    <h2>Drivers</h2>

    <InertiaLink :href="route('admin.drivers.create')" class="btn btn-primary my-3">Add driver</InertiaLink>

    <table class="table table-bordered table-dark">
        <thead>
        <tr>
            <th>Name</th>
            <th>Team</th>
            <th>Owner</th>
            <th class="text-center">Series</th>
            <th class="text-center">DOB</th>
            <th class="text-center">Rating</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="driver in drivers" :key="driver.id">
            <td>{{ driver.full_name }}</td>
            <td>{{ driver.team.name }}</td>
            <td>{{ driver.owner.name }}</td>
            <td class="centered medium" :style="driver.series.style">{{ driver.series.name }}</td>
            <td class="centered medium">{{ driver.date_of_birth }}</td>
            <td class="centered medium">{{ driver.rating }}</td>
            <td class="centered small">
                <InertiaLink :href="route('admin.drivers.edit', [driver])">edit</InertiaLink>
            </td>
            <td class="centered small">
                <InertiaLink :href="route('admin.drivers.show', [driver])">view</InertiaLink>
            </td>
        </tr>
        <tr v-for="freeAgent in freeAgents" :key="freeAgent.id">
            <td>{{ freeAgent.full_name }}</td>
            <td>Free agent</td>
            <td>N/A</td>
            <td class="centered medium">N/A</td>
            <td class="centered medium">{{ freeAgent.date_of_birth }}</td>
            <td class="centered medium">{{ freeAgent.rating }}</td>
            <td class="centered small">
                <InertiaLink :href="route('admin.drivers.edit', [freeAgent])">edit</InertiaLink>
            </td>
            <td class="centered small">
                <InertiaLink :href="route('admin.drivers.show', [freeAgent])">view</InertiaLink>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script setup lang="ts">
import DetailedDriver from '@/Interfaces/Drivers/DetailedDriver';

interface Props {
    drivers: DetailedDriver[],
    freeAgents: DetailedDriver[],
}

defineProps<Props>();
</script>

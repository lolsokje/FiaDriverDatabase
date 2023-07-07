<template>
    <h1>Drivers</h1>

    <InertiaLink :href="route('admin.drivers.create')" class="btn btn-primary m-y-4">Add driver</InertiaLink>

    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Team</th>
            <th>Owner</th>
            <th class="text-center">Series</th>
            <th class="text-center">DOB</th>
            <th class="text-center">Rating</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="driver in drivers" :key="driver.id">
            <DriverName :driver="driver"/>
            <td>{{ driver.team.name }}</td>
            <td>{{ driver.owner.name }}</td>
            <td class="centered medium">
                <SeriesStyle :team="driver.team"/>
            </td>
            <td class="centered medium">{{ driver.date_of_birth }}</td>
            <td class="centered medium">{{ driver.rating }}</td>
            <td class="centered small">
                <InertiaLink :href="route('admin.drivers.edit', [driver])">edit</InertiaLink>
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
        </tr>
        </tbody>
    </table>
</template>

<script setup lang="ts">
import DetailedDriver from '@/Interfaces/Drivers/DetailedDriver';
import SeriesStyle from '@/Components/SeriesStyle.vue';
import DriverName from '@/Components/DriverName.vue';

interface Props {
    drivers: DetailedDriver[],
    freeAgents: DetailedDriver[],
}

defineProps<Props>();
</script>

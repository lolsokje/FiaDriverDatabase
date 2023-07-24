<template>
    <div class="container">
        <h1>Drivers</h1>

        <InertiaLink :href="route('admin.drivers.create')" class="btn btn-primary m-y-4">Add driver</InertiaLink>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>Driver</th>
                    <th>User</th>
                    <th class="text-center">Date of birth</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="driver in drivers" :key="driver.id">
                    <td>{{ driver.full_name }}</td>
                    <td>{{ driver.user.username }}</td>
                    <td class="centered large">{{ driver.dob.formatted }}</td>
                    <td class="centered small">
                        <InertiaLink :href="route('admin.drivers.edit', driver)">edit</InertiaLink>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Driver from '@/Contracts/Driver';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';

interface Props {
    drivers: Driver[],
}

defineProps<Props>();

breadcrumbStore.breadcrumbs = [];
</script>

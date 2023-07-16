<template>
    <h1 class="m-b-3">{{ team.name }}</h1>
    <h4>Owned by {{ team.owner.name }}</h4>

    <table class="table m-y-4">
        <thead>
        <tr>
            <th>Driver name</th>
            <th class="centered">Rating</th>
            <th class="centered">Age</th>
            <th class="centered">ID</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="driver in form.drivers" :key="driver.id">
            <DriverName :driver="driver"/>
            <td class="centered medium">
                <input type="number" v-model="driver.rating">
            </td>
            <td class="centered small">{{ driver.age }}</td>
            <td class="centered medium">
                <input type="text" v-model="driver.driver_id">
            </td>
            <td class="centered small">
                <a @click.prevent="deleteDriver(driver)" class="text-primary" role="button">delete</a>
            </td>
        </tr>
        </tbody>
    </table>

    <form @submit.prevent="form.put(route('admin.teams.drivers.update', team))">
        <button class="btn btn-primary m-y-4">Save drivers</button>
    </form>

    <div class="m-t-4">
        <div class="m-b-4">
            <label for="driver" class="form-label">Add a driver</label>
            <select id="driver" v-model="driver">
                <option value="">Select a driver</option>
                <option v-for="driver in allDrivers" :key="driver.id" :value="driver.id">{{ driver.full_name }}</option>
            </select>
        </div>

        <button class="btn btn-secondary" role="button" @click.prevent="addDriver()">Add driver</button>
    </div>
</template>

<script setup lang="ts">
import { Ref, ref } from 'vue';
import DetailedTeam from '@/Interfaces/Teams/DetailedTeam';
import BaseDriver from '@/Interfaces/Drivers/BaseDriver';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import { useForm } from '@inertiajs/vue3';
import DriverName from '@/Components/DriverName.vue';

interface Props {
    team: DetailedTeam,
    drivers: BaseDriver[],
}

interface Form {
    drivers: BaseDriver[],
}

const props = defineProps<Props>();

const allDrivers: Ref<BaseDriver[]> = ref(props.drivers);
const driver: Ref<string> = ref('');

const form = useForm<Form>({
    drivers: props.team.drivers,
});

const addDriver = (): void => {
    const newDriver = allDrivers.value.find(d => d.id === driver.value);

    if (! newDriver) {
        return;
    }

    form.drivers.push(newDriver);
    allDrivers.value = allDrivers.value.filter(d => d.id !== newDriver.id);
    driver.value = '';
};

const deleteDriver = (driver: BaseDriver): void => {
    form.drivers = form.drivers.filter(d => d.id !== driver.id);
    allDrivers.value.push(driver);
};

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Teams', route('admin.teams.index')),
    new Breadcrumb(props.team.name),
    new Breadcrumb('Details'),
];
</script>

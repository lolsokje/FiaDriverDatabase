<template>
    <h1 class="m-b-3">{{ team.name }}</h1>
    <h4>Owned by {{ team.owner.name }}</h4>

    <div class="m-y-4">
        <div>
            <input type="checkbox" id="edit-mode" v-model="editMode">
            <label for="edit-mode" class="form-label-inline m-l-3">Edit ratings</label>
        </div>

        <div v-if="editMode">
            <button type="button" class="btn btn-primary m-t-3" @click.prevent="saveDriverRatings">
                Save ratings
            </button>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Driver name</th>
            <th class="centered">Rating</th>
            <th class="centered large" v-if="editMode">Edit rating</th>
            <th class="centered">Age</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="driver in drivers" :key="driver.id">
            <td>{{ driver.full_name }}</td>
            <td class="centered small">{{ driver.rating }}</td>
            <td class="centered large" v-if="editMode">
                <input type="number" v-model="driver.rating">
            </td>
            <td class="centered small">{{ driver.age }}</td>
            <td class="centered small">
                <a @click.prevent="deleteDriver(driver)" class="text-primary" role="button">delete</a>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="m-t-4">
        <div class="m-b-4">
            <label for="driver" class="form-label">Add a driver</label>
            <select id="driver" v-model="driver">
                <option value="">Select a driver</option>
                <option v-for="driver in allDrivers" :key="driver.id" :value="driver.id">{{ driver.full_name }}</option>
            </select>
        </div>

        <button class="btn btn-primary" role="button" @click.prevent="addDriver">Add driver</button>
    </div>
</template>

<script setup lang="ts">
import { Ref, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import DetailedTeam from '@/Interfaces/Teams/DetailedTeam';
import BaseDriver from '@/Interfaces/Drivers/BaseDriver';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';

interface Props {
    team: DetailedTeam,
    drivers: BaseDriver[],
}

const props = defineProps<Props>();

const drivers: Ref<BaseDriver[]> = ref(props.team.drivers);
const allDrivers: Ref<BaseDriver[]> = ref(props.drivers);
const driver: Ref<string> = ref('');
const editMode: Ref<boolean> = ref(false);

const deleteDriver = (driver: BaseDriver): void => {
    if (! confirm(`Are you sure you want to remove this driver from ${props.team.name}?`)) {
        return;
    }

    drivers.value = drivers.value.filter((d) => d.id !== driver.id);

    router.delete(route('admin.teams.driver.delete', [ props.team, driver ]), {
        replace: true,
        preserveState: true,
    });
};

const addDriver = (): void => {
    const id = driver.value;

    if (id === '') {
        return;
    }

    if (drivers.value.find((d) => d.id === id)) {
        return;
    }

    const newDriver = allDrivers.value.find((d) => d.id === id);

    if (! newDriver) {
        return;
    }

    router.put(route('admin.teams.driver.add', [ props.team, newDriver ]), {
        replace: true,
        preserveState: true,
    });

    drivers.value.push(newDriver);
    allDrivers.value = allDrivers.value.filter((d) => d.id !== newDriver.id);

    driver.value = '';
};

const saveDriverRatings = (): void => {
    const params = drivers.value.map((driver) => {
        return {
            id: driver.id,
            rating: driver.rating,
        };
    });

    router.put(route('admin.drivers.ratings.update'), { drivers: params }, { replace: true, preserveState: true });
};

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Teams', route('admin.teams.index')),
    new Breadcrumb(props.team.name),
    new Breadcrumb('Details'),
];
</script>
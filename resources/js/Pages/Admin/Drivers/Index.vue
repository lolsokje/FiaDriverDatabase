<template>
    <h1>Drivers</h1>

    <InertiaLink :href="route('admin.drivers.create')" class="btn btn-primary m-y-4">Add driver</InertiaLink>

    <div class="grid grid-cols-1 w-full md:w-1/2 m-b-4">
        <div>
            <label for="series" class="form-label">Series</label>
            <select class="form-select" id="series" v-model="filters.series">
                <option value="">Select a series</option>
                <option v-for="item in series" :key="item.id" :value="item.id">{{ item.name }}</option>
                <option value="fa">Free Agent</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
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
            <tr v-for="driver in filteredDrivers" :key="driver.id">
                <td>{{ driver.driver_id }}</td>
                <DriverName :driver="driver"/>
                <td>{{ driver.team?.name ?? 'Free Agent' }}</td>
                <td>{{ driver.team?.owner.name ?? 'N/A' }}</td>
                <td class="centered medium">
                    <SeriesStyle :team="driver.team" v-if="driver.team"/>
                    <template v-else>N/A</template>
                </td>
                <td class="centered medium">{{ driver.date_of_birth }}</td>
                <td class="centered medium">{{ driver.rating }}</td>
                <td class="centered small">
                    <InertiaLink :href="route('admin.drivers.edit', [driver])">edit</InertiaLink>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import DetailedDriver from '@/Interfaces/Drivers/DetailedDriver';
import SeriesStyle from '@/Components/SeriesStyle.vue';
import DriverName from '@/Components/DriverName.vue';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import BaseSeries from '@/Interfaces/Series/BaseSeries';
import { reactive, ref, Ref, watch } from 'vue';

interface Props {
    series: BaseSeries[],
    drivers: DetailedDriver[],
}

interface Filters {
    series: '',
}

const props = defineProps<Props>();

const filteredDrivers: Ref<DetailedDriver[]> = ref(props.drivers);

const filters: Filters = reactive({
    series: '',
});

watch(filters, () => {
    const series = filters.series;
    let filtered = props.drivers;

    if (series !== '') {
        if (series === 'fa') {
            filtered = filtered.filter((driver) => driver.team === null);
        } else {
            filtered = filtered.filter((driver) => driver.team?.series_id === series);
        }
    }

    filteredDrivers.value = filtered;
});

breadcrumbStore.breadcrumbs = [];
</script>

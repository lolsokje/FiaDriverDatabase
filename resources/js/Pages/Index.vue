<template>
    <h1 class="m-t-6 m-b-4">Drivers - {{ year }}</h1>

    <div class="filter-wrapper m-b-4">
        <div>
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="filters.name">
        </div>

        <div>
            <label for="series" class="form-label">Series</label>
            <select class="form-select" id="series" v-model="filters.series">
                <option value="">Select a series</option>
                <option v-for="item in series" :key="item.id" :value="item.id">{{ item.name }}</option>
                <option value="fa">Free Agent</option>
            </select>
        </div>

        <div>
            <label for="series" class="form-label">Min Age</label>
            <input type="text" id="min_age" v-model="filters.min_age">
        </div>
        <div>
            <label for="series" class="form-label">Max Age</label>
            <input type="text" id="max_age" v-model="filters.max_age">
        </div>

        <div>
            <label for="series" class="form-label">Min Rating</label>
            <input type="text" id="min_rating" v-model="filters.min_rating">
        </div>
        <div>
            <label for="series" class="form-label">Max Rating</label>
            <input type="text" id="max_rating" v-model="filters.max_rating">
        </div>
    </div>

    <p class="m-b-4">{{ filteredDrivers.length }} of {{ drivers.length }} drivers shown</p>

    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Team</th>
            <th>Owner</th>
            <th class="text-center">Series</th>
            <th class="text-center">DOB</th>
            <th class="text-center">Age</th>
            <th class="text-center">Rating</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="driver in filteredDrivers" :key="driver.id">
            <DriverName :driver="driver"/>
            <td>{{ driver.team?.name ?? 'Free Agent' }}</td>
            <td>{{ driver.team?.owner.name ?? 'N/A' }}</td>
            <td class="centered medium">
                <SeriesStyle :team="driver.team" v-if="driver.team"/>
                <template v-else>N/A</template>
            </td>
            <td class="centered medium">{{ driver.date_of_birth }}</td>
            <td class="centered small">{{ driver.age }}</td>
            <td class="centered medium">{{ driver.rating }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script setup lang="ts">
import { computed, ComputedRef, reactive, Ref, ref, watch } from 'vue';
import DetailedDriver from '@/Interfaces/Drivers/DetailedDriver';
import BaseSeries from '@/Interfaces/Series/BaseSeries';
import SeriesStyle from '@/Components/SeriesStyle.vue';
import DriverName from '@/Components/DriverName.vue';

interface Props {
    drivers: DetailedDriver[],
    series: BaseSeries[],
    year: number,
}

interface Filters {
    name: string,
    series: string,
    min_age: number,
    max_age: number,
    min_rating: number,
    max_rating: number,
}

const props = defineProps<Props>();

const filters: Filters = reactive({
    name: '',
    series: '',
    min_age: 0,
    max_age: 0,
    min_rating: 0,
    max_rating: 0,
});

const filteredDrivers: Ref<DetailedDriver[]> = ref(props.drivers);

const minAge: ComputedRef<number> = computed(() => Number(filters.min_age) || 0);
const maxAge: ComputedRef<number> = computed(() => Number(filters.max_age) || 0);
const minRating: ComputedRef<number> = computed(() => Number(filters.min_rating) || 0);
const maxRating: ComputedRef<number> = computed(() => Number(filters.max_rating) || 0);

watch(filters, () => {
    const name = filters.name.toLowerCase();
    const minimumAge = minAge.value;
    const maximumAge = maxAge.value;
    const minimumRating = minRating.value;
    const maximumRating = maxRating.value;
    const series = filters.series;


    if (name === '' && series === '' && minimumAge === 0 && maximumAge === 0 && minimumRating === 0 && maximumRating === 0) {
        filteredDrivers.value = props.drivers;
        return;
    }

    let filtered = props.drivers;

    if (name !== '') {
        filtered = filtered.filter((driver) => driver.full_name.toLowerCase().includes(name));
    }

    if (series !== '') {
        if (series === 'fa') {
            filtered = filtered.filter((driver) => driver.team === null);
        } else {
            filtered = filtered.filter((driver) => driver.team?.series_id === series);
        }
    }

    if (minimumAge !== 0) {
        filtered = filtered.filter((driver) => driver.age >= minimumAge);
    }

    if (maximumAge !== 0) {
        if (maximumAge > minimumAge) {
            filtered = filtered.filter((driver) => driver.age <= maximumAge);
        }
    }

    if (minimumRating !== 0) {
        filtered = filtered.filter((driver) => driver.rating >= minimumRating);
    }

    if (maximumRating !== 0) {
        if (maximumRating > minimumRating) {
            filtered = filtered.filter((driver) => driver.rating <= maximumRating);
        }
    }

    filteredDrivers.value = filtered;
});
</script>

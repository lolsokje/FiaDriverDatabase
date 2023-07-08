<template>
    <h2 class="m-b-5">Perform driver development</h2>

    <div style="display:flex;justify-content: space-between" class="m-b-5">
        <button class="btn btn-primary" @click.prevent="runDev()">Run dev</button>
        <button class="btn btn-secondary" @click.prevent="saveDev()" v-if="devPerformed">Save dev</button>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Driver</th>
            <th>Team</th>
            <th class="centered">Series</th>
            <th class="centered">Age</th>
            <th class="centered">Rating</th>
            <th class="centered">Dev</th>
            <th class="centered">New rating</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="driver in devDrivers" :key="driver.id">
            <DriverName :driver="driver"/>
            <td>{{ driver.team?.name ?? 'Free agent' }}</td>
            <td class="centered">
                <SeriesStyle :team="driver.team" v-if="driver.team"/>
                <template v-else>N/A</template>
            </td>
            <td class="centered">
                {{ driver.age }}
            </td>
            <td class="centered">
                {{ driver.rating }}
            </td>
            <td class="centered">
                {{ driver.dev ?? '' }}
            </td>
            <td class="centered">
                {{ driver.newRating }}
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script lang="ts" setup>
import DetailedDriver from '@/Interfaces/Drivers/DetailedDriver';
import AgeRange from '@/Interfaces/Development/AgeRange';
import DriverName from '@/Components/DriverName.vue';
import SeriesStyle from '@/Components/SeriesStyle.vue';
import RatingRange from '@/Interfaces/Development/RatingRange';
import { onMounted, ref, Ref } from 'vue';
import { router } from '@inertiajs/vue3';

interface DevDriver extends DetailedDriver {
    dev: number,
    newRating: number,
}

interface Props {
    drivers: DevDriver[],
    ageRanges: AgeRange[],
}

interface DriverDevRange {
    [key: string]: RatingRange,
}

const props = defineProps<Props>();

const devDrivers: Ref<DevDriver[]> = ref(props.drivers);
const driverDevRanges: Ref<DriverDevRange[]> = ref([]);
const devPerformed: Ref<boolean> = ref(false);

const runDev = (): void => {
    props.drivers.forEach(driver => {
        const range: RatingRange = driverDevRanges.value[driver.id];

        driver.dev = getRoll(range.min_dev, range.max_dev);
        driver.newRating = driver.rating + driver.dev;
    });

    devPerformed.value = true;
};

const saveDev = (): void => {
    const drivers = props.drivers.map(driver => {
        return {
            id: driver.id,
            rating: driver.rating,
            dev: driver.dev,
            new_rating: driver.newRating,
        };
    });

    router.post(route('admin.development.results.store'), { drivers: drivers }, {
        preserveState: true,
        preserveScroll: true,
    });

    devPerformed.value = false;
};

const getRoll = (min: number, max: number): number => {
    return Math.floor(Math.random() * (max - min + 1) + min);
};

const getRatingRangeForDriver = (driver: DetailedDriver): RatingRange => {
    const ageRange = getAgeRangeForDriver(driver);
    const ratingRange = ageRange.ranges.find(r => driver.rating >= r.min_rating && driver.rating <= r.max_rating);

    if (! ratingRange) {
        alert(`No relevant rating range could be found for [${driver.full_name}], rating [${driver.rating}]`);
        return;
    }

    return ratingRange;
};

const getAgeRangeForDriver = (driver: DetailedDriver): AgeRange => {
    const ageRange = props.ageRanges.find(r => driver.age <= r.max_age && driver.age >= r.min_age);

    if (! ageRange) {
        alert(`No relevant age range could be found for [${driver.full_name}], age [${driver.age}]`);
        return;
    }

    return ageRange;
};

onMounted(() => {
    props.drivers.forEach(driver => {
        driverDevRanges.value[driver.id] = getRatingRangeForDriver(driver);
    });
});
</script>

<template>
    <h2 class="m-b-5">Development configuration</h2>

    <form @submit.prevent="form.post(route('admin.development.store'))" v-if="validRanges" class="m-y-4">
        <button type="submit" class="btn btn-primary">Save development ranges</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="min_age" class="form-label">Minimum age</label>
            <input type="number" id="min_age" v-model="state.min_age">
        </div>

        <div>
            <label for="max_age" class="form-label">Maximum age</label>
            <input type="number" id="max_age" v-model="state.max_age">
        </div>
    </div>

    <div class="m-t-4 m-b-5">
        <button role="button" class="btn btn-primary" @click="addAgeRange">
            Add age range
        </button>
    </div>

    <div v-for="(ageRange, index) in form.ageRanges" class="m-t-4 overflow-x-auto" :key="index">
        <h2>Age range: {{ ageRange.min_age }} - {{ ageRange.max_age }}</h2>
        <div class="m-y-4 flex justify-between">
            <button type="button" @click="addRatingRange(ageRange)" class="btn btn-secondary">Add dev range</button>
            <button type="button" @click="deleteAgeRange(ageRange)" class="btn btn-danger">
                Delete age range
            </button>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th class="centered">Min rating</th>
                <th class="centered">Max rating</th>
                <th class="centered">Min dev</th>
                <th class="centered">Max dev</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-center" v-for="(range, index) in ageRange.ranges" :key="index">
                <td><input type="number" v-model="range.min_rating"></td>
                <td><input type="number" v-model="range.max_rating"></td>
                <td><input type="number" v-model="range.min_dev"></td>
                <td><input type="number" v-model="range.max_dev"></td>
                <td>
                    <a @click.prevent="deleteRatingRange(ageRange, range)">delete</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <form @submit.prevent="form.post(route('admin.development.store'))" class="m-y-4" v-if="validRanges">
        <button type="submit" class="btn btn-primary">Save development ranges</button>
    </form>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import { computed, ComputedRef, reactive } from 'vue';
import AgeRange from '@/Interfaces/Development/AgeRange';
import RatingRange from '@/Interfaces/Development/RatingRange';
import { developmentStore } from '@/Stores/DevelopmentStore';

interface Form {
    ageRanges: AgeRange[],
}

interface State {
    min_age: number,
    max_age: number,
}

const form = useForm<Form>({
    ageRanges: developmentStore.ageRanges ?? [],
});

const state: State = reactive({
    min_age: 0,
    max_age: 17,
});

const validRanges: ComputedRef<boolean> = computed(() => {
    return form.ageRanges.length > 0 && ! form.ageRanges.some((range) => range.ranges.length === 0);
});

const addAgeRange = (): void => {
    form.ageRanges.push({
        min_age: state.min_age,
        max_age: state.max_age,
        ranges: [],
    });

    state.min_age = state.max_age + 1;
    state.max_age = state.min_age + 10;
};

const deleteAgeRange = (ageRange: AgeRange): void => {
    form.ageRanges = form.ageRanges.filter((range) => range !== ageRange);
};

const addRatingRange = (ageRange: AgeRange): void => {
    const latestMaxRating = ageRange.ranges.at(-1)?.max_rating ?? 0;
    ageRange.ranges.push({
        id: 0,
        min_rating: latestMaxRating + 1,
        max_rating: latestMaxRating + 10,
        min_dev: 0,
        max_dev: 0,
    });
};

const deleteRatingRange = (ageRange: AgeRange, ratingRage: RatingRange): void => {
    ageRange.ranges = ageRange.ranges.filter((r) => r !== ratingRage);
};
</script>

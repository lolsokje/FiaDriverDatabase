<template>
    <h1>Add driver</h1>

    <form @submit.prevent="form.post(route('admin.drivers.store'))" class="m-t-5">
        <div class="m-b-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="series" class="form-label">Series</label>
                <select v-model="form.series_id" id="series">
                    <option v-for="item in series" :key="item.id" :value="item.id">{{ item.name }}</option>
                </select>
            </div>

            <div>
                <label for="team" class="form-label">Team (leave blank for free agent)</label>
                <select v-model="form.team_id" id="team">
                    <option value="">Select a team</option>
                    <option v-for="team in teams" :key="team.id" :value="team.id">{{ team.name }}</option>
                </select>
            </div>
        </div>

        <div class="m-b-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="first_name" class="form-label">First name</label>
                <input type="text" id="first_name" v-model="form.first_name" required>
            </div>

            <div>
                <label for="last_name" class="form-label">Last name</label>
                <input type="text" id="last_name" v-model="form.last_name" required>
            </div>
        </div>

        <div class="m-b-4 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="dob" class="form-label">Date of birth</label>
                <input type="date" id="dob" v-model="form.dob" required>
            </div>

            <div>
                <label for="rating" class="form-label">Rating</label>
                <input type="number" id="rating" v-model="form.rating" min="0" required>
            </div>

            <div>
                <label for="driver_id" class="form-label">Driver ID</label>
                <input type="text" id="driver_id" v-model="form.driver_id">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add driver</button>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed, ComputedRef } from 'vue';
import DetailedSeries from '@/Interfaces/Series/DetailedSeries';
import BaseTeam from '@/Interfaces/Teams/BaseTeam';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';

interface Props {
    series: DetailedSeries[],
}

interface Form {
    series_id: string,
    team_id: string,
    first_name: string,
    last_name: string,
    dob: string,
    rating: string,
    driver_id: string,
}

const props = defineProps<Props>();

const teams: ComputedRef<BaseTeam[]> = computed(() => props.series.find(s => s.id === form.series_id)?.teams ?? []);

const form = useForm<Form>({
    series_id: props.series[0].id,
    team_id: '',
    first_name: '',
    last_name: '',
    dob: '',
    rating: '',
    driver_id: '',
});

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Drivers', route('admin.drivers.index')),
    new Breadcrumb('Create'),
];
</script>

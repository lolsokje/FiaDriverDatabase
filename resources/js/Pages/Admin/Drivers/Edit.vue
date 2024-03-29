<template>
    <h1>Update driver</h1>

    <form @submit.prevent="form.put(route('admin.drivers.update', [driver]))" class="m-t-5">
        <div class="m-b-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="series" class="form-label">Series</label>
                <select v-model="form.series_id" id="series">
                    <option value="">Select a series</option>
                    <option v-for="item in series" :key="item.id" :value="item.id">{{ item.name }}</option>
                </select>
            </div>

            <div class="col-6">
                <label for="team" class="form-label">Team (leave blank for free agent)</label>
                <select v-model="form.team_id" id="team">
                    <option value="" v-if="teams.length">Select a team</option>
                    <option value="" v-else>Select a series first</option>
                    <option v-for="team in teams" :key="team.id" :value="team.id">{{ team.name }}</option>
                </select>
            </div>
        </div>

        <div class="m-b-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="first_name" class="form-label">First name</label>
                <input type="text" id="first_name" v-model="form.first_name" required>
            </div>

            <div class="col-6">
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
                <div class="form-group">
                    <span class="form-group-addon">
                    {{ teamId }}
                    </span>
                    <input type="text" id="driver_id" v-model="form.driver_id">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update driver</button>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed, ComputedRef } from 'vue';
import DetailedSeries from '@/Interfaces/Series/DetailedSeries';
import BaseTeam from '@/Interfaces/Teams/BaseTeam';
import DetailedDriver from '@/Interfaces/Drivers/DetailedDriver';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';

interface Props {
    driver: DetailedDriver,
    series: DetailedSeries[],
}

interface Form {
    series_id: string,
    team_id: string,
    first_name: string,
    last_name: string,
    dob: string,
    rating: number,
    driver_id: string,
}

const props = defineProps<Props>();

const teams: ComputedRef<BaseTeam[]> = computed(() => props.series.find(s => s.id === form.series_id)?.teams ?? []);

const teamId: ComputedRef<string> = computed(() => {
    const team: BaseTeam | undefined = teams.value.find(t => t.id === form.team_id);

    return team ? team.team_id : '';
});

const form = useForm<Form>({
    series_id: props.driver.team ? props.driver.team.series_id : '',
    team_id: props.driver.team_id ?? '',
    first_name: props.driver.first_name,
    last_name: props.driver.last_name,
    dob: props.driver.dob,
    rating: props.driver.rating,
    driver_id: props.driver.driver_id,
});

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Drivers', route('admin.drivers.index')),
    new Breadcrumb(props.driver.full_name),
    new Breadcrumb('Edit'),
];
</script>

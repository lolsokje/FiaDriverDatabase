<template>
    <h2>Update driver</h2>

    <form @submit.prevent="form.put(route('admin.drivers.update', [driver]))">
        <div class="md-3">
            <div class="row">
                <div class="col-6">
                    <label for="series" class="form-label">Series</label>
                    <select v-model="form.series_id" id="series" class="form-control" @change="getTeams">
                        <option value="">Select a series</option>
                        <option v-for="item in series" :key="item.id" :value="item.id">{{ item.name }}</option>
                    </select>
                </div>

                <div class="col-6">
                    <label for="team" class="form-label">Team (leave blank for free agent)</label>
                    <select v-model="form.team_id" id="team" class="form-control">
                        <option value="" v-if="teams.length">Select a team</option>
                        <option value="" v-else>Select a series first</option>
                        <option v-for="team in teams" :key="team.id" :value="team.id">{{ team.name }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="first_name" class="form-label">First name</label>
                    <input type="text" id="first_name" v-model="form.first_name" class="form-control" required>
                </div>

                <div class="col-6">
                    <label for="last_name" class="form-label">Last name</label>
                    <input type="text" id="last_name" v-model="form.last_name" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="dob" class="form-label">Date of birth</label>
                    <input type="date" id="dob" v-model="form.dob" class="form-control" required>
                </div>

                <div class="col-6">
                    <label for="rating" class="form-label">Rating</label>
                    <input type="number" id="rating" v-model="form.rating" class="form-control" min="0" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update driver</button>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    driver: {
        type: Object,
        required: true,
    },
    series: {
        type: Array,
        required: true,
    },
});

const teams = computed(() => {
    if (form.series_id) {
        return props.series.find((serie) => serie.id === form.series_id).teams;
    }
    return [];
});

const form = useForm({
    series_id: props.driver.team ? props.driver.team.series_id : '',
    team_id: props.driver.team_id ?? '',
    first_name: props.driver.first_name,
    last_name: props.driver.last_name,
    dob: props.driver.dob,
    rating: props.driver.rating,
});
</script>

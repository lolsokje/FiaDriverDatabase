<template>
    <h1>Teams</h1>

    <InertiaLink :href="route('admin.teams.create')" class="btn btn-primary m-y-4">Add team</InertiaLink>

    <div class="grid grid-cols-2 gap-1 m-b-4">
        <div>
            <select v-model="filters.owner" @change.prevent="filterTeams">
                <option value="">Filter by owner</option>
                <option v-for="owner in owners" :key="owner.id" :value="owner.id">{{ owner.name }}</option>
            </select>
        </div>

        <div>
            <select v-model="filters.series" @change.prevent="filterTeams">
                <option value="">Filter by series</option>
                <option v-for="championship in series" :key="championship.id" :value="championship.id">
                    {{ championship.name }}
                </option>
            </select>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Owner</th>
            <th class="text-center">Series</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="team in filteredTeams" :key="team.id">
            <td>{{ team.name }}</td>
            <td>{{ team.owner.name }}</td>
            <td class="centered medium">
                <SeriesStyle :team="team"/>
            </td>
            <td class="centered small">
                <InertiaLink :href="route('admin.teams.edit', [team])">edit</InertiaLink>
            </td>
            <td class="centered small">
                <InertiaLink :href="route('admin.teams.show', [team])">view</InertiaLink>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script setup lang="ts">
import { reactive, Ref, ref } from 'vue';
import BaseOwner from '@/Interfaces/Owners/BaseOwner';
import DetailedTeam from '@/Interfaces/Teams/DetailedTeam';
import DetailedSeries from '@/Interfaces/Series/DetailedSeries';
import SeriesStyle from '@/Components/SeriesStyle.vue';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';

interface Props {
    teams: DetailedTeam[],
    owners: BaseOwner[],
    series: DetailedSeries[],
}

interface Filters {
    owner: string,
    series: string,
}

const props = defineProps<Props>();

const filteredTeams: Ref<DetailedTeam[]> = ref(props.teams);

const filters: Filters = reactive({
    owner: '',
    series: '',
});

const filterTeams = (): void => {
    const owner = filters.owner;
    const series = filters.series;

    filteredTeams.value = props.teams.filter(team => {
        if (owner !== '' && series !== '') {
            return team.owner_id === owner && team.series_id === series;
        }

        if (owner !== '') {
            return team.owner_id === owner;
        }

        if (series !== '') {
            return team.series_id === series;
        }

        return true;
    });
};

breadcrumbStore.breadcrumbs = [];
</script>

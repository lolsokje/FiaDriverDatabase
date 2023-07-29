<template>
    <div class="container">
        <h1>Teams</h1>

        <InertiaLink :href="route('admin.teams.create', series)" class="btn btn-primary m-y-4">Add team</InertiaLink>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>Full name</th>
                    <th>Short name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="team in teams" :key="team.id">
                    <td>{{ team.full_name }}</td>
                    <td>{{ team.short_name }}</td>
                    <td class="centered small">
                        <InertiaLink :href="route('admin.teams.edit', [series, team])">edit</InertiaLink>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import route from 'ziggy-js';
import Series from '@/Contracts/Series';
import Team from '@/Contracts/Team';

interface Props {
    series: Series;
    teams: Team[],
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Series', route('admin.series.index')),
    new Breadcrumb(props.series.name),
    new Breadcrumb('Teams'),
];
</script>

<template>
    <div class="container">
        <h1 class="m-y-4">Edit team</h1>

        <Teams :series="series" :team="team"/>
    </div>
</template>

<script lang="ts" setup>
import Team from '@/Contracts/Team';
import Series from '@/Contracts/Series';
import Teams from '@/Forms/Admin/Teams.vue';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import route from 'ziggy-js';

interface Props {
    series: Series,
    team: Team,
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Series', route('admin.series.index')),
    new Breadcrumb(props.series.name, route('admin.series.index', props.series)),
    new Breadcrumb('Teams', route('admin.teams.index', props.series)),
    new Breadcrumb(props.team.full_name),
    new Breadcrumb('Edit'),
];
</script>

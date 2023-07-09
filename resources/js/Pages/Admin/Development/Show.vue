<template>
    <h2 class="m-b-5">Development results</h2>

    <button class="btn btn-danger m-y-5" @click.prevent="restore()">Restore</button>

    <table class="table">
        <thead>
        <tr>
            <th>Driver</th>
            <th>Team</th>
            <th class="centered">Series</th>
            <th class="centered">Old rating</th>
            <th class="centered">Dev</th>
            <th class="centered">New rating</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="result in results" :key="result.id">
            <td>{{ result.driver.full_name }}</td>
            <td>{{ result.team?.name ?? 'Free Agent' }}</td>
            <td class="centered small">
                <SeriesStyle :team="result.team" v-if="result.team"/>
                <template v-else>N/A</template>
            </td>
            <td class="centered small">{{ result.rating }}</td>
            <td class="centered small">{{ result.dev }}</td>
            <td class="centered small">{{ result.new_rating }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script lang="ts" setup>
import DevelopmentRound from '@/Interfaces/Development/DevelopmentRound';
import DevelopmentResult from '@/Interfaces/Development/DevelopmentResult';
import SeriesStyle from '@/Components/SeriesStyle.vue';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import route from 'ziggy-js';
import { Tabs } from '@/Enums/Tab';
import { router } from '@inertiajs/vue3';

interface Props {
    round: DevelopmentRound,
    results: DevelopmentResult[],
}

const props = defineProps<Props>();

const restore = (): void => {
    if (! confirm('Are you sure you want to restore ratings from this round? This will delete the current and any subsequent development rounds')) {
        return;
    }

    router.delete(route('admin.development.results.destroy', props.round));
};

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Development', route('admin.development.index')),
    new Breadcrumb('Results', route('admin.development.index', { tab: Tabs.HISTORY })),
    new Breadcrumb(props.round.year.toString()),
];
</script>

<template>
    <h2 class="m-b-5">Development history</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Year</th>
            <th class="centered">Performed</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="round in rounds" :key="round.id">
            <td class="w-full">{{ round.year }}</td>
            <td class="centered">{{ round.created_at }}</td>
            <td class="centered small">
                <InertiaLink :href="route('admin.development.rounds.show', round)">show</InertiaLink>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script lang="ts" setup>
import DevelopmentRound from '@/Interfaces/Development/DevelopmentRound';

interface Props {
    rounds: DevelopmentRound[],
}

defineProps<Props>();
</script>

<template>
    <span :style="team.series.style" class="series-style">
        {{ team.series.name }}
    </span>
</template>

<script lang="ts" setup>
import DetailedTeam from '@/Interfaces/Teams/DetailedTeam';

interface Props {
    team: DetailedTeam,
}

defineProps<Props>();
</script>

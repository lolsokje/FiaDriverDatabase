<template>
    <span :style="series.style" class="series-style">
        {{ series.name }}
    </span>
</template>

<script lang="ts" setup>
import DetailedSeries from '@/Interfaces/Series/DetailedSeries';

interface Props {
    series: DetailedSeries,
}

defineProps<Props>();
</script>

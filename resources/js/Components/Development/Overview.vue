<template>
    <h2 class="m-b-5">Development ranges overview</h2>

    <div class="grid grid-cols-2 gap-6">
        <div v-for="ageRange in developmentStore.ageRanges" :key="ageRange.id">
            <h2 class="m-b-4">{{ ageRange.min_age }} - {{ ageRange.max_age }} year old</h2>

            <table class="table">
                <thead>
                <tr>
                    <th class="centered">Max rating</th>
                    <th class="centered">Min dev</th>
                    <th class="centered">Max dev</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="range in ageRange.ranges" :key="range.id">
                    <td class="centered">{{ range.max_rating }}</td>
                    <td class="centered">{{ range.min_dev }}</td>
                    <td class="centered">{{ range.max_dev }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { developmentStore } from '@/Stores/DevelopmentStore';
</script>

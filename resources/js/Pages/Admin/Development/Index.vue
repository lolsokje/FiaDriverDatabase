<template>
    <h1>Driver development</h1>

    <div class="tab-container m-t-4 m-b-5">
        <div class="tab" v-for="devTab in Tabs" :class="{ 'active': active(devTab) }" @click.prevent="tab = devTab">
            <h3>{{ devTab }}</h3>
        </div>
    </div>

    <Perform v-if="active(Tabs.PERFORM)" :drivers="drivers" :ageRanges="ageRanges"/>
    <Overview v-if="active(Tabs.OVERVIEW)" :ageRanges="ageRanges"/>
    <Configuration v-if="active(Tabs.CONFIGURATION)" :ageRanges="ageRanges"/>
    <History v-if="active(Tabs.HISTORY)" :rounds="developmentRounds"/>
</template>

<script setup lang="ts">
import Configuration from '@/Components/Development/Configuration.vue';
import AgeRange from '@/Interfaces/Development/AgeRange';
import { ref, Ref } from 'vue';
import Overview from '@/Components/Development/Overview.vue';
import Perform from '@/Components/Development/Perform.vue';
import DetailedDriver from '@/Interfaces/Drivers/DetailedDriver';
import DevelopmentRound from '@/Interfaces/Development/DevelopmentRound';
import History from '@/Components/Development/History.vue';

interface Props {
    drivers: DetailedDriver[],
    ageRanges: AgeRange[],
    developmentRounds: DevelopmentRound[],
}

enum Tabs {
    PERFORM = 'Perform',
    OVERVIEW = 'Overview',
    CONFIGURATION = 'Configuration',
    HISTORY = 'History',
}

defineProps<Props>();

const tab: Ref<string> = ref(Tabs.PERFORM);

const active = (tabToCheck: string): boolean => {
    return tab.value === tabToCheck;
};
</script>

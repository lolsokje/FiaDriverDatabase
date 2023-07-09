<template>
    <h1>Driver development</h1>

    <div class="tab-container m-t-4 m-b-5">
        <div class="tab" v-for="devTab in Tabs" :class="{ 'active': active(devTab) }" @click.prevent="tab = devTab">
            <h3>{{ devTab }}</h3>
        </div>
    </div>

    <Perform v-if="active(Tabs.PERFORM)"/>
    <Overview v-if="active(Tabs.OVERVIEW)"/>
    <Configuration v-if="active(Tabs.CONFIGURATION)"/>
    <History v-if="active(Tabs.HISTORY)"/>
</template>

<script setup lang="ts">
import Configuration from '@/Components/Development/Configuration.vue';
import AgeRange from '@/Interfaces/Development/AgeRange';
import { ref, Ref } from 'vue';
import Overview from '@/Components/Development/Overview.vue';
import Perform from '@/Components/Development/Perform.vue';
import DevelopmentRound from '@/Interfaces/Development/DevelopmentRound';
import History from '@/Components/Development/History.vue';
import { developmentStore } from '@/Stores/DevelopmentStore';
import DevDriver from '@/Interfaces/Drivers/DevDriver';

interface Props {
    drivers: DevDriver[],
    ageRanges: AgeRange[],
    developmentRounds: DevelopmentRound[],
    year: number,
}

enum Tabs {
    PERFORM = 'Perform',
    OVERVIEW = 'Overview',
    CONFIGURATION = 'Configuration',
    HISTORY = 'History',
}

const props = defineProps<Props>();

const tab: Ref<string> = ref(Tabs.PERFORM);

const active = (tabToCheck: string): boolean => {
    return tab.value === tabToCheck;
};

developmentStore.drivers = props.drivers;
developmentStore.ageRanges = props.ageRanges;
developmentStore.developmentRounds = props.developmentRounds;
developmentStore.year = props.year;
</script>

import { reactive } from 'vue';
import AgeRange from '@/Interfaces/Development/AgeRange';
import DevelopmentRound from '@/Interfaces/Development/DevelopmentRound';
import DevDriver from '@/Interfaces/Drivers/DevDriver';

interface DevelopmentStore {
    drivers: DevDriver[],
    ageRanges: AgeRange[],
    developmentRounds: DevelopmentRound[],
    year: number,
}

export let developmentStore: DevelopmentStore = reactive({
    drivers: [],
    ageRanges: [],
    developmentRounds: [],
    year: 0,
});

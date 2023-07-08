import BaseDriver from '@/Interfaces/Drivers/BaseDriver';
import BaseTeam from '@/Interfaces/Teams/BaseTeam';
import BaseSeries from '@/Interfaces/Series/BaseSeries';

export default interface DevelopmentResult {
    id: string,
    driver: BaseDriver,
    team: BaseTeam,
    series: BaseSeries,
    rating: number,
    dev: number,
    new_rating: number,
}

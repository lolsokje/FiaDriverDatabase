import BaseSeries from '@/Interfaces/Series/BaseSeries';
import BaseTeam from '@/Interfaces/Teams/BaseTeam';

export default interface DetailedSeries extends BaseSeries {
    background_colour: string,
    text_colour: string,
    style: string,
    teams: BaseTeam[]
}

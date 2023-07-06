import BaseTeam from '@/Interfaces/Teams/BaseTeam';
import BaseOwner from '@/Interfaces/Owners/BaseOwner';
import DetailedSeries from '@/Interfaces/Series/DetailedSeries';
import BaseDriver from '@/Interfaces/Drivers/BaseDriver';

export default interface DetailedTeam extends BaseTeam {
    owner_id: string,
    series_id: string,
    owner: BaseOwner,
    series: DetailedSeries,
    drivers: BaseDriver[],
}

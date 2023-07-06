import BaseDriver from '@/Interfaces/Drivers/BaseDriver';
import BaseOwner from '@/Interfaces/Owners/BaseOwner';
import DetailedSeries from '@/Interfaces/Series/DetailedSeries';
import DetailedTeam from '@/Interfaces/Teams/DetailedTeam';

export default interface DetailedDriver extends BaseDriver {
    owner: BaseOwner,
    series: DetailedSeries,
    team: DetailedTeam,
}

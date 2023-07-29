import Series from '@/Contracts/Series';

export default interface Engine {
    id: string,
    series_id: string,
    name: string,
    series?: Series,
}

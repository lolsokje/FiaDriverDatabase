import Series from '@/Contracts/Series';

export default interface Season {
    id: string,
    year: number,
    series?: Series,
}

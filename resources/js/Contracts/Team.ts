import Series from '@/Contracts/Series';

export default interface Team {
    id: string,
    series?: Series,
    full_name: string,
    short_name: string,
    primary_colour: string,
    secondary_colour: string,
}

import DetailedDriver from '@/Interfaces/Drivers/DetailedDriver';

export default interface DevDriver extends DetailedDriver {
    dev: number,
    newRating: number,
}

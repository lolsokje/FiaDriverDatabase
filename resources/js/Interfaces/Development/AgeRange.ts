import RatingRange from '@/Interfaces/Development/RatingRange';

export default interface AgeRange {
    id?: string,
    min_age: number,
    max_age: number,
    ranges: RatingRange[],
}

import Date from '@/Contracts/Date';
import User from '@/Contracts/User';

export default interface Driver {
    id: string,
    first_name: string,
    last_name: string,
    full_name: string,
    dob: Date,
    user?: User,
}

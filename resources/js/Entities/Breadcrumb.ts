import BreadcrumbItem from '@/Contracts/BreadcrumbItem';

export default class Breadcrumb implements BreadcrumbItem {
    text: string;
    link: string | null;

    constructor (text: string, link: string | null = null) {
        this.text = text;
        this.link = link;
    }
}

import { reactive } from 'vue';
import BreadcrumbItem from '@/Contracts/BreadcrumbItem';

interface BreadcrumbStore {
    breadcrumbs: BreadcrumbItem[],
}

export let breadcrumbStore: BreadcrumbStore = reactive({
    breadcrumbs: [],
});

import { reactive } from 'vue';
import BreadcrumbItem from '@/Interfaces/BreadcrumbItem';

interface BreadcrumbStore {
    breadcrumbs: BreadcrumbItem[],
}

export let breadcrumbStore: BreadcrumbStore = reactive({
    breadcrumbs: [],
});

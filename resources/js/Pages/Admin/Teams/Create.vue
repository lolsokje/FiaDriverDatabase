<template>
    <h1>Add team</h1>

    <form @submit.prevent="form.post(route('admin.teams.store'))" class="m-t-5">
        <div class="m-b-4">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="form.name" required>
        </div>

        <div class="m-b-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="owner_id" class="form-label">Owner</label>
                <select v-model="form.owner_id" id="owner_id" required>
                    <option value="">Select an owner</option>
                    <option v-for="owner in owners" :key="owner.id" :value="owner.id">{{ owner.name }}</option>
                </select>
            </div>

            <div>
                <label for="owner_id" class="form-label">Series</label>
                <select v-model="form.series_id" id="series_id" required>
                    <option value="">Select a series</option>
                    <option v-for="item in series" :key="item.id" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add team</button>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import BaseOwner from '@/Interfaces/Owners/BaseOwner';
import BaseSeries from '@/Interfaces/Series/BaseSeries';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';

interface Props {
    owners: BaseOwner[],
    series: BaseSeries[],
}

interface Form {
    name: string,
    series_id: string,
    owner_id: string,
}

defineProps<Props>();

const form = useForm<Form>({
    name: '',
    series_id: '',
    owner_id: '',
});

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Teams', route('admin.teams.index')),
    new Breadcrumb('Create'),
];
</script>

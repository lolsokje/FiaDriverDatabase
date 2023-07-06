<template>
    <h2>Add team</h2>

    <form @submit.prevent="form.post(route('admin.teams.store'))">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" v-model="form.name" class="form-control" required>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="owner_id" class="form-label">Owner</label>
                    <select v-model="form.owner_id" id="owner_id" class="form-control" required>
                        <option value="">Select an owner</option>
                        <option v-for="owner in owners" :key="owner.id" :value="owner.id">{{ owner.name }}</option>
                    </select>
                </div>

                <div class="col-6">
                    <label for="owner_id" class="form-label">Series</label>
                    <select v-model="form.series_id" id="series_id" class="form-control" required>
                        <option value="">Select a series</option>
                        <option v-for="item in series" :key="item.id" :value="item.id">{{ item.name }}</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add team</button>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

defineProps({
    owners: {
        type: Array,
        required: true,
    },
    series: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: '',
    series_id: '',
    owner_id: '',
});
</script>

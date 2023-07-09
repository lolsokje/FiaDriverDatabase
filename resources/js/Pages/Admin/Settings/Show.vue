<template>
    <h1>General settings</h1>

    <table class="table m-t-5">
        <thead>
        <tr>
            <th>Setting</th>
            <th class="centered">Value</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Year</td>
            <td class="centered large">
                <input type="number" v-model="settings.year">
            </td>
            <td class="centered small">
                <button class="btn btn-primary" @click="saveSetting('year')">Save</button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore.js';

const props = defineProps({
    year: {
        type: Number,
        required: true,
    },
});

const settings = reactive({
    year: props.year,
});

function saveSetting (setting) {
    const params = {};
    params[setting] = settings[setting];
    router.post(route('admin.settings.store'), params, { replace: true, preserveState: true });
}

breadcrumbStore.breadcrumbs = [];
</script>

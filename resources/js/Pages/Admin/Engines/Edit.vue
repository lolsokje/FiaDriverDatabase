<template>
    <div class="container">
        <h1 class="m-y-4">Edit engine</h1>

        <Engines :series="series" :engine="engine"/>
    </div>
</template>

<script lang="ts" setup>
import Series from '@/Contracts/Series';
import { breadcrumbStore } from '@/Stores/BreadcrumbStore';
import Breadcrumb from '@/Entities/Breadcrumb';
import route from 'ziggy-js';
import Engine from '@/Contracts/Engine';
import Engines from '@/Forms/Admin/Engines.vue';

interface Props {
    series: Series,
    engine: Engine,
}

const props = defineProps<Props>();

breadcrumbStore.breadcrumbs = [
    new Breadcrumb('Series', route('admin.series.index')),
    new Breadcrumb(props.series.name, route('admin.series.index', props.series)),
    new Breadcrumb('Engines', route('admin.engines.index', props.series)),
    new Breadcrumb(props.engine.name),
    new Breadcrumb('Edit'),
];
</script>

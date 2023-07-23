<template>
    <div class="container">
        <h1 class="m-b-4">Edit series</h1>

        <Series :series="series"/>
    </div>
</template>

<script lang="ts" setup>
import Series from '@/Forms/Admin/Series.vue';

interface Props {
    series: Series,
}

defineProps<Props>();
</script>

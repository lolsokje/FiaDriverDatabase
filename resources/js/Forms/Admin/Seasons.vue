<template>
    <form @submit.prevent="handleForm()">
        <div class="m-b-4">
            <label for="year" class="form-label">Year</label>
            <FormInput id="year" v-model="form.year" :error="form.errors.year" type="number"/>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</template>

<script lang="ts" setup>
import Series from '@/Contracts/Series';
import { useForm } from '@inertiajs/vue3';
import Season from '@/Contracts/Season';
import route from 'ziggy-js';
import FormInput from '@/Components/Form/FormInput.vue';

interface Props {
    series: Series,
    season?: Season,
}

interface Form {
    year: string,
}

const props = defineProps<Props>();

const form = useForm<Form>({
    year: props.season?.year.toString() ?? '',
});

const handleForm = (): void => {
    if (props.season) {
        form.put(route('admin.seasons.update', [ props.series, props.season ]));
    } else {
        form.post(route('admin.seasons.store', props.series));
    }
};
</script>

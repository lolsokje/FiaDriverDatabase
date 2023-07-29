<template>
    <form @submit.prevent="handleForm()">
        <div class="m-b-4">
            <label for="name" class="form-label">Name</label>
            <FormInput id="name" v-model="form.name" :error="form.errors.name"/>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</template>

<script lang="ts" setup>
import Series from '@/Contracts/Series';
import { useForm } from '@inertiajs/vue3';
import route from 'ziggy-js';
import Engine from '@/Contracts/Engine';
import FormInput from '@/Components/Form/FormInput.vue';

interface Props {
    series: Series,
    engine?: Engine,
}

interface Form {
    name: string,
}

const props = defineProps<Props>();

const form = useForm<Form>({
    name: props.engine?.name ?? '',
});

const handleForm = (): void => {
    if (props.engine) {
        form.put(route('admin.engines.update', [ props.series, props.engine ]));
    } else {
        form.post(route('admin.engines.store', props.series));
    }
};
</script>

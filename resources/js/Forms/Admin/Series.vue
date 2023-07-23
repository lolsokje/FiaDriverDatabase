<template>
    <form @submit.prevent="handleForm()">
        <div class="m-b-4">
            <label for="name" class="form-label">Name</label>
            <FormInput id="name" v-model="form.name" :error="form.errors.name"/>
        </div>

        <div class="flex m-b-4">
            <div>
                <label for="primary_colour" class="form-label">Primary colour</label>
                <FormInput id="primary_colour"
                           type="color"
                           v-model="form.primary_colour"
                           :error="form.errors.primary_colour"
                />
            </div>

            <div>
                <label for="secondary_colour" class="form-label">Secondary colour</label>
                <FormInput id="secondary_colour"
                           type="color"
                           v-model="form.secondary_colour"
                           :error="form.errors.secondary_colour"
                />
            </div>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/Form/FormInput.vue';
import Series from '@/Contracts/Series';

interface Props {
    series?: Series;
}

const props = defineProps<Props>();

interface Form {
    name: string,
    primary_colour: string,
    secondary_colour: string,
}

const form = useForm<Form>({
    name: props.series?.name ?? '',
    primary_colour: props.series?.primary_colour ?? '#000000',
    secondary_colour: props.series?.secondary_colour ?? '#000000',
});

const handleForm = (): void => {
    if (props.series) {
        form.put(route('admin.series.update', props.series));
    } else {
        form.post(route('admin.series.store'));
    }
};
</script>

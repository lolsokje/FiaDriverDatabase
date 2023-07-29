<template>
    <form @submit.prevent="handleForm()">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 m-b-4">
            <div>
                <label for="full_name" class="form-label">Full name</label>
                <FormInput id="full_name" v-model="form.full_name" :error="form.errors.full_name"/>
            </div>

            <div>
                <label for="short_name" class="form-label">Full name</label>
                <FormInput id="short_name" v-model="form.short_name" :error="form.errors.short_name"/>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-x-6 m-b-4">
            <div>
                <label for="primary_colour" class="form-label">Primary colour</label>
                <ColourPicker v-model="form.primary_colour" :error="form.errors.primary_colour"/>
            </div>

            <div>
                <label for="secondary_colour" class="form-label">Secondary colour</label>
                <ColourPicker v-model="form.secondary_colour" :error="form.errors.secondary_colour"/>
            </div>
        </div>

        <TeamStylePreview :name="form.full_name" :primary="form.primary_colour" :secondary="form.secondary_colour"/>

        <button class="btn btn-primary">Save</button>
    </form>
</template>

<script lang="ts" setup>
import Team from '@/Contracts/Team';
import { useForm } from '@inertiajs/vue3';
import route from 'ziggy-js';
import TeamStylePreview from '@/Components/TeamStylePreview.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import ColourPicker from '@/Components/Form/ColourPicker.vue';
import Series from '@/Contracts/Series';

interface Props {
    series: Series,
    team?: Team,
}

interface Form {
    full_name: string,
    short_name: string,
    primary_colour: string,
    secondary_colour: string,
}

const props = defineProps<Props>();

const form = useForm<Form>({
    full_name: props.team?.full_name ?? '',
    short_name: props.team?.short_name ?? '',
    primary_colour: props.team?.primary_colour ?? '#FFFFFF',
    secondary_colour: props.team?.secondary_colour ?? '#000000',
});

const handleForm = (): void => {
    if (props.team) {
        form.put(route('admin.teams.update', [ props.series, props.team ]));
    } else {
        form.post(route('admin.teams.store', props.series));
    }
};
</script>

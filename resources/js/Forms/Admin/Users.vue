<template>
    <form @submit.prevent="handleForm()">
        <div class="mb-4">
            <label for="username" class="form-label">Username</label>
            <FormInput id="username" v-model="form.username" :error="form.errors.username"/>
        </div>

        <div class="mb-4">
            <label for="discord_id" class="form-label">Discord ID</label>
            <FormInput id="discord_id" v-model="form.discord_id" :error="form.errors.discord_id"/>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/Form/FormInput.vue';
import User from '@/Contracts/User';

interface Props {
    user?: User,
}

interface Form {
    username: string,
    discord_id: string,
}

const props = defineProps<Props>();

const form = useForm<Form>({
    username: props.user?.username ?? '',
    discord_id: props.user?.discord_id ?? '',
});

const handleForm = (): void => {
    if (props.user) {
        form.put(route('admin.users.update', props.user));
    } else {
        form.post(route('admin.users.store'));
    }
};
</script>

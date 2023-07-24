<template>
    <form @submit.prevent="handleForm()">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 m-b-4">
            <div>
                <label for="first_name" class="form-label">First name</label>
                <FormInput id="first_name" v-model="form.first_name" :error="form.errors.first_name"/>
            </div>

            <div>
                <label for="last_name" class="form-label">Last name</label>
                <FormInput id="last_name" v-model="form.last_name" :error="form.errors.first_name"/>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 m-b-4">
            <div>
                <label for="user" class="form-label">User</label>
                <select id="user" v-model="form.user_id" required>
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.username }}</option>
                </select>
                <p class="error-message" v-if="form.errors.user_id">{{ form.errors.user_id }}</p>
            </div>

            <div>
                <label for="dob" class="form-label">Date of birth</label>
                <FormInput id="dob" v-model="form.dob" type="date"/>
            </div>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/Form/FormInput.vue';
import User from '@/Contracts/User';
import Driver from '@/Contracts/Driver';

interface Props {
    driver?: Driver,
    users: User[],
}

interface Form {
    user_id: string,
    first_name: string,
    last_name: string,
    dob: string,
}

const props = defineProps<Props>();

const form = useForm<Form>({
    user_id: props.driver?.user?.id ?? '',
    first_name: props.driver?.first_name ?? '',
    last_name: props.driver?.last_name ?? '',
    dob: props.driver?.dob.raw ?? '',
});

const handleForm = (): void => {
    if (props.driver) {
        form.put(route('admin.drivers.update', props.driver));
    } else {
        form.post(route('admin.drivers.store'));
    }
};
</script>

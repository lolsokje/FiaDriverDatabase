<template>
    <input :type="type"
           :value="modelValue"
           :id="id"
           @input.prevent="emit('update:modelValue', $event.target.value)"
           :class="{ 'error': error }"
           required
    >
    <p class="error-message" v-if="error">{{ error }}</p>
</template>

<script lang="ts" setup>
interface Props {
    type?: string,
    id: string,
    modelValue: string,
    error?: string,
}

withDefaults(defineProps<Props>(), {
    type: 'text',
});

const emit = defineEmits([ 'update:modelValue' ]);
</script>

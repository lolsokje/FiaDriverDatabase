<template>
    <Sketch v-model="colour"/>
    <p class="error-message" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
import { Ref, ref, watch } from 'vue';
import { Sketch } from '@ckpack/vue-color';

interface Props {
    modelValue: string,
    error?: string,
}

interface Payload {
    hex: string,
}

const props = defineProps<Props>();

const emit = defineEmits([ 'update:modelValue' ]);
const colour: Ref<Payload> = ref(props.modelValue as Payload);

watch(colour, () => {
    emit('update:modelValue', colour.value.hex);
});
</script>

<style scoped>
.vc-sketch {
    color: black;
}
</style>

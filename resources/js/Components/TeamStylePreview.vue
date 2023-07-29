<template>
    <div class="w-full lg:w-6/12 lg:mx-auto my-12 text-center py-4 rounded font-bold"
         :style="`background-color: ${primary};color: ${secondary}`"
    >
        {{ name !== '' ? name : 'Placeholder' }}
    </div>
</template>

<script lang="ts" setup>
interface Props {
    name: string,
    primary: string,
    secondary: string,
}

defineProps<Props>();
</script>

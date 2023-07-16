<template>
    <MainNav/>

    <div class="container px-4 sm:px-0 m-t-4">
        <slot/>
    </div>
</template>

<script setup>
import MainNav from '@/Shared/MainNav.vue';
</script>

<script>
export default { name: 'Main' };
</script>

<template>
    <AdminNav/>

    <div class="container px-4 sm:px-0">
        <slot/>
    </div>
</template>

<script setup>
import AdminNav from '@/Shared/AdminNav.vue';
</script>

<script>
export default { name: 'Admin' };
</script>

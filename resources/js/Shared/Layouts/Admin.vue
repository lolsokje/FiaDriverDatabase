<template>
    <AdminNav/>

    <div class="container">
        <slot/>
    </div>
</template>

<script setup>
import AdminNav from '@/Shared/AdminNav.vue';
</script>

<script>
export default { name: 'Admin' };
</script>

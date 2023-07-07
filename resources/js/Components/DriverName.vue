<template>
    <td class="driver-name">
        <span class="first-name">{{ driver.first_name }}</span>&nbsp;
        <span class="last-name">{{ driver.last_name }}</span>
    </td>
</template>

<script lang="ts" setup>
import BaseDriver from '@/Interfaces/Drivers/BaseDriver';

interface Props {
    driver: BaseDriver,
}

defineProps<Props>();
</script>

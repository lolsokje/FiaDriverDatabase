<template>
	<AdminNav/>

	<div class="container">
		<slot/>
	</div>
</template>

<script setup>

import AdminNav from '../AdminNav';</script>

<script>
export default { name: 'Admin' };
</script>

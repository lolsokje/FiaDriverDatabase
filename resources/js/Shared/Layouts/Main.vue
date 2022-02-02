<template>
	<MainNav/>

	<div class="container mt-3">
		<slot/>
	</div>
</template>

<script setup>

import MainNav from '../MainNav';</script>

<script>
export default { name: 'Main' };
</script>

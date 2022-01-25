<template>
	<MainNav/>

	<div class="container">
		<slot/>
	</div>
</template>

<script setup>

import MainNav from '../MainNav';</script>

<script>
export default { name: 'Main' };
</script>

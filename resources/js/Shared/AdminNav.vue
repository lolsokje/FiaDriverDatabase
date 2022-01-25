<template>
	<nav class="navbar navbar-expand-lg bg-dark">
		<div class="container">
			<ul class="navbar-nav">
				<li class="nav-item">
					<InertiaLink :href="route('admin.series.index')" class="nav-link">Series</InertiaLink>
				</li>
				<li class="nav-item">
					<InertiaLink :href="route('admin.owners.index')" class="nav-link">Owners</InertiaLink>
				</li>
				<li class="nav-item">
					<InertiaLink :href="route('admin.teams.index')" class="nav-link">Teams</InertiaLink>
				</li>
			</ul>
		</div>
	</nav>
</template>

<script setup>

</script>

<script>
export default { name: 'AdminNav' };
</script>

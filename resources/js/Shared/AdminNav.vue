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
				<li class="nav-item">
					<InertiaLink :href="route('admin.drivers.index')" class="nav-link">Drivers</InertiaLink>
				</li>
				<li class="nav-item">
					<InertiaLink :href="route('admin.settings.show')" class="nav-link">Settings</InertiaLink>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
					   data-bs-toggle="dropdown">
						Development
					</a>
					<ul class="dropdown-menu">
						<li>
							<InertiaLink :href="route('admin.development.show')" class="dropdown-item">
								Setup
							</InertiaLink>
						</li>
						<li>
							<InertiaLink :href="route('admin.development.index')" class="dropdown-item">
								Overview
							</InertiaLink>
						</li>
						<li>
							<InertiaLink href="#" class="dropdown-item">Perform dev</InertiaLink>
						</li>
					</ul>
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

<template>
	<h2>Owners</h2>

	<InertiaLink :href="route('admin.owners.create')" class="btn btn-primary my-3">Add owner</InertiaLink>

	<table class="table table-bordered table-dark">
		<thead>
		<tr>
			<th>Name</th>
			<th colspan="2"></th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="owner in owners" :key="owner.id">
			<td>{{ owner.name }}</td>
			<td class="centered small">
				<InertiaLink :href="route('admin.owners.edit', [owner])">edit</InertiaLink>
			</td>
			<td class="centered small">
				<InertiaLink :href="route('admin.owners.show', [owner])">view</InertiaLink>
			</td>
		</tr>
		</tbody>
	</table>
</template>

<script setup>
defineProps({
	owners: {
		type: Array,
		required: true,
	},
});
</script>

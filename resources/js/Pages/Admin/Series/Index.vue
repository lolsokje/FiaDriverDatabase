<template>
	<h2>Series</h2>

	<InertiaLink :href="route('admin.series.create')" class="btn btn-primary my-3">Add series</InertiaLink>

	<table class="table table-bordered table-dark">
		<thead>
		<tr>
			<th>Name</th>
			<th colspan="2"></th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="item in series" :key="item.id">
			<td>{{ item.name }}</td>
			<td class="centered small">
				<InertiaLink :href="route('admin.series.edit', [item])">edit</InertiaLink>
			</td>
			<td class="centered small">
				<InertiaLink :href="route('admin.series.show', [item])">view</InertiaLink>
			</td>
		</tr>
		</tbody>
	</table>
</template>

<script setup>
defineProps({
	series: {
		type: Array,
		required: true,
	},
});
</script>

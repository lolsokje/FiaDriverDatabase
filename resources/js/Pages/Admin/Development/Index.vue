<template>
	<h2 class="mb-3">Current development ranges</h2>

	<div class="row">
		<div class="col-4" v-for="ageRange in ageRanges" :key="ageRange.id">
			<h3>{{ ageRange.min_age }} - {{ ageRange.max_age }} year old</h3>
			<table class="table table-bordered table-dark text-center mb-5 mt-3">
				<thead>
				<tr>
					<th>Max rating</th>
					<th>Min dev</th>
					<th>Max dev</th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="range in ageRange.ranges" :key="range.id">
					<td>{{ range.max_rating }}</td>
					<td>{{ range.min_dev }}</td>
					<td>{{ range.max_dev }}</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script setup>
defineProps({
	ageRanges: {
		type: Array,
		required: true,
	},
});
</script>

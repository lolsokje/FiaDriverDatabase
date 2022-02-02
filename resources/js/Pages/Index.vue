<template>
	<h2>Drivers - {{ year }}</h2>

	<div class="row mt-3">
		<div class="col-3">
			<div class="form-floating mb-3">
				<input type="text" class="form-control" id="name" v-model="filters.name">
				<label for="name">Name</label>
			</div>
		</div>

		<div class="col-3">
			<div class="form-floating mb-3">
				<select class="form-select" id="series" v-model="filters.series">
					<option value="">Select a series</option>
					<option v-for="item in series" :key="item.id" :value="item.id">{{ item.name }}</option>
					<option value="fa">Free Agent</option>
				</select>
				<label for="series">Series</label>
			</div>
		</div>

		<div class="col-3 row">
			<div class="col-6">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" id="min_age" v-model="filters.min_age">
					<label for="series">Min Age</label>
				</div>
			</div>
			<div class="col-6">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" id="max_age" v-model="filters.max_age">
					<label for="series">Max Age</label>
				</div>
			</div>
		</div>

		<div class="col-3 row">
			<div class="col-6">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" id="min_rating" v-model="filters.min_rating">
					<label for="series">Min Rating</label>
				</div>
			</div>
			<div class="col-6">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" id="max_rating" v-model="filters.max_rating">
					<label for="series">Max Rating</label>
				</div>
			</div>
		</div>
	</div>

	<p>{{ filteredDrivers.length }} of {{ drivers.length }} drivers shown</p>

	<table class="table table-bordered table-dark">
		<thead>
		<tr>
			<th>Name</th>
			<th>Team</th>
			<th>Owner</th>
			<th class="text-center">Series</th>
			<th class="text-center">DOB</th>
			<th class="text-center">Age</th>
			<th class="text-center">Rating</th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="driver in filteredDrivers" :key="driver.id">
			<td>{{ driver.name }}</td>
			<td>{{ driver.team }}</td>
			<td>{{ driver.owner }}</td>
			<td class="centered medium" :style="driver.style">{{ driver.series }}</td>
			<td class="centered medium">{{ driver.date_of_birth }}</td>
			<td class="centered small">{{ driver.age }}</td>
			<td class="centered medium">{{ driver.rating }}</td>
		</tr>
		</tbody>
	</table>
</template>

<script setup>
import { onMounted, reactive, ref, watch } from 'vue';

const props = defineProps({
	drivers: {
		type: Array,
		required: true,
	},
	series: {
		type: Array,
		required: true,
	},
	year: {
		type: Number,
		required: true,
	},
});

const allDrivers = ref([]);
const filteredDrivers = ref([]);

const filters = reactive({
	name: '',
	series: '',
	min_age: 0,
	max_age: 0,
	min_rating: 0,
	max_rating: 0,
});

onMounted(() => {
	allDrivers.value = props.drivers.map((driver) => {
		const isFreeAgent = driver.team_id === null;

		return {
			name: driver.full_name,
			team: isFreeAgent ? 'Free Agent' : driver.team.name,
			owner: isFreeAgent ? 'N/A' : driver.team.owner.name,
			series: isFreeAgent ? 'N/A' : driver.series.name,
			series_id: isFreeAgent ? null : driver.series.id,
			style: isFreeAgent ? '' : driver.series.style,
			date_of_birth: driver.date_of_birth,
			age: driver.age,
			rating: driver.rating,
		};
	});

	filteredDrivers.value = allDrivers.value;
});

watch(filters, () => {
	let filtered = allDrivers.value;

	if (filters.name !== '') {
		filtered = filtered.filter((driver) => driver.name.toLowerCase().includes(filters.name.toLowerCase()));
	}

	if (filters.series !== '') {
		if (filters.series === 'fa') {
			filtered = filtered.filter((driver) => driver.team === 'Free Agent');
		} else {
			filtered = filtered.filter((driver) => driver.series_id === filters.series);
		}
	}

	if (filters.min_age !== 0) {
		filtered = filtered.filter((driver) => driver.age >= filters.min_age);
	}

	if (filters.max_age !== 0) {
		if (filters.max_age > filters.min_age) {
			filtered = filtered.filter((driver) => driver.age <= filters.max_age);
		}
	}

	if (filters.min_rating !== 0) {
		filtered = filtered.filter((driver) => driver.rating >= filters.min_rating);
	}

	if (filters.max_rating !== 0) {
		if (filters.max_rating > filters.min_rating) {
			filtered = filtered.filter((driver) => driver.rating <= filters.max_rating);
		}
	}

	filteredDrivers.value = filtered;
});
</script>

<script>
export default { name: 'Index' };
</script>

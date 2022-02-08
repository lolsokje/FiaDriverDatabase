<template>
	<h2>{{ team.name }}</h2>
	<p>Owned by {{ team.owner.name }}</p>

	<table class="table table-bordered table-dark">
		<thead>
		<tr>
			<th>Driver name</th>
			<th class="centered">Rating</th>
			<th class="centered">Age</th>
			<th colspan="2"></th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="driver in drivers" :key="driver.id">
			<td>{{ driver.full_name }}</td>
			<td class="centered small">{{ driver.rating }}</td>
			<td class="centered small">{{ driver.age }}</td>
			<td class="centered small">
				<InertiaLink :href="route('admin.drivers.show', [driver])">
					view
				</InertiaLink>
			</td>
			<td class="centered small">
				<a @click.prevent="deleteDriver(driver)" class="text-primary" role="button">delete</a>
			</td>
		</tr>
		</tbody>
	</table>

	<div class="mt-3">
		<div class="mb-3 col-3">
			<label for="driver" class="form-label">Add a driver</label>
			<select id="driver" class="form-control col-6" v-model="driver">
				<option value="">Select a driver</option>
				<option v-for="driver in allDrivers" :key="driver.id" :value="driver.id">{{ driver.full_name }}</option>
			</select>
		</div>

		<button class="btn btn-primary" role="button" @click.prevent="addDriver">Add driver</button>
	</div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
	team: {
		type: Array,
		required: true,
	},
	drivers: {
		type: Array,
		required: true,
	},
});

const drivers = ref(props.team.drivers);
const allDrivers = ref(props.drivers);
const driver = ref('');

function deleteDriver (driver) {
	if (confirm(`Are you sure you want to remove this driver from ${props.team.name}?`)) {
		drivers.value = drivers.value.filter((d) => d.id !== driver.id);

		Inertia.delete(route('admin.teams.driver.delete', [props.team, driver]), {
			replace: true,
			preserveState: true,
		});

		allDrivers.value.push(driver);
	}
}

function addDriver () {
	const id = driver.value;

	if (id === '') {
		return;
	}

	if (drivers.value.find((d) => d.id === id)) {
		return;
	}

	const newDriver = allDrivers.value.find((d) => d.id === id);
	drivers.value.push(newDriver);
	allDrivers.value = allDrivers.value.filter((d) => d.id !== newDriver.id);

	driver.value = '';

	Inertia.put(route('admin.teams.driver.add', [props.team, newDriver]), {
		replace: true,
		preserveState: true,
	});
}
</script>

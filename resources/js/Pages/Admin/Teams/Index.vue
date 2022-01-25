<template>
	<h2>Teams</h2>

	<InertiaLink :href="route('admin.teams.create')" class="btn btn-primary my-3">Add team</InertiaLink>

	<div class="row col-6">
		<div class="col-6">
			<select v-model="filters.owner" class="form-control mb-3" @change.prevent="filterTeams">
				<option value="">Filter by owner</option>
				<option v-for="owner in owners" :key="owner.id" :value="owner.id">{{ owner.name }}</option>
			</select>
		</div>

		<div class="col-6">
			<select v-model="filters.series" class="form-control mb-3" @change.prevent="filterTeams">
				<option value="">Filter by series</option>
				<option v-for="championship in series" :key="championship.id" :value="championship.id">
					{{ championship.name }}
				</option>
			</select>
		</div>
	</div>

	<table class="table table-bordered table-dark">
		<thead>
		<tr>
			<th>Name</th>
			<th>Owner</th>
			<th class="text-center">Series</th>
			<th colspan="2"></th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="team in filteredTeams" :key="team.id">
			<td>{{ team.name }}</td>
			<td>{{ team.owner.name }}</td>
			<td :style="team.series.style" class="centered medium">{{ team.series.name }}</td>
			<td class="centered small">
				<InertiaLink :href="route('admin.teams.edit', [team])">edit</InertiaLink>
			</td>
			<td class="centered small">
				<InertiaLink :href="route('admin.teams.show', [team])">view</InertiaLink>
			</td>
		</tr>
		</tbody>
	</table>
</template>

<script setup>
import { reactive, ref } from 'vue';

const props = defineProps({
	teams: {
		type: Array,
		required: true,
	},
	owners: {
		type: Array,
		required: true,
	},
	series: {
		type: Array,
		required: true,
	},
});

const filteredTeams = ref(props.teams);

const filters = reactive({
	owner: '',
	series: '',
});

function filterTeams () {
	const owner = filters.owner;
	const series = filters.series;

	filteredTeams.value = props.teams.filter((team) => {
		if (owner !== '' && series !== '') {
			return team.owner_id === owner && team.series_id === series;
		} else if (owner !== '') {
			return team.owner_id === owner;
		} else if (series !== '') {
			return team.series_id === series;
		}
		return true;
	});
}
</script>

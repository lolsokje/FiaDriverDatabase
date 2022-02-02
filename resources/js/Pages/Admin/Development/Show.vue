<template>
	<h2>Driver development setup</h2>

	<form @submit.prevent="form.post(route('admin.development.store'))" v-if="validRanges" class="my-3">
		<button type="submit" class="btn btn-primary">Save development ranges</button>
	</form>

	<div class="row align-items-end">
		<div class="col-2">
			<label for="min_age" class="form-label">Minimum age</label>
			<input type="number" id="min_age" v-model="state.min_age" class="form-control">
		</div>

		<div class="col-2">
			<label for="max_age" class="form-label">Maximum age</label>
			<input type="number" id="max_age" v-model="state.max_age" class="form-control">
		</div>
		<div class="col-2">
			<button role="button" class="btn btn-primary" @click="addAgeRange">
				Add age range
			</button>
		</div>
	</div>

	<div v-for="(ageRange, index) in form.ageRanges" class="mt-3" :key="index">
		<h3>Age range: {{ ageRange.min_age }} - {{ ageRange.max_age }}</h3>
		<div class="d-flex">
			<button type="button" @click="addRange(ageRange)" class="btn btn-info my-3">Add dev range</button>
			<button type="button" @click="deleteAgeRange(ageRange)" class="btn btn-danger align-self-center ms-auto">
				Delete age range
			</button>
		</div>
		<table class="table table-bordered table-dark my-3">
			<thead>
			<tr class="text-center">
				<th>Min rating</th>
				<th>Max rating</th>
				<th>Min dev</th>
				<th>Max dev</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<tr class="text-center" v-for="(range, index) in ageRange.ranges" :key="index">
				<td><input type="number" class="form-control text-center" v-model="range.min_rating"></td>
				<td><input type="number" class="form-control text-center" v-model="range.max_rating"></td>
				<td><input type="number" class="form-control text-center" v-model="range.min_dev"></td>
				<td><input type="number" class="form-control text-center" v-model="range.max_dev"></td>
				<td>
					<button type="button" class="btn btn-link text-decoration-none"
							@click="deleteRange(ageRange, range)">delete
					</button>
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<form @submit.prevent="form.post(route('admin.development.store'))" class="mt-3 pb-5" v-if="validRanges">
		<button type="submit" class="btn btn-primary">Save development ranges</button>
	</form>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { computed, onMounted, reactive } from 'vue';

const props = defineProps({
	ageRanges: {
		type: Array,
		required: false,
	},
});

const form = useForm({
	ageRanges: [],
});

const state = reactive({
	min_age: 0,
	max_age: 17,
});

const validRanges = computed(() => {
	return form.ageRanges.length > 0 && !form.ageRanges.some((range) => range.ranges.length === 0);
});

function addAgeRange () {
	form.ageRanges.push({
		min_age: state.min_age,
		max_age: state.max_age,
		ranges: [],
	});

	state.min_age = state.max_age + 1;
	state.max_age = state.min_age + 10;
}

function deleteAgeRange (ageRange) {
	form.ageRanges = form.ageRanges.filter((range) => range !== ageRange);
}

function addRange (ageRange) {
	ageRange.ranges.push({
		min_rating: 0,
		max_rating: 0,
		min_dev: 0,
		max_dev: 0,
	});
}

function deleteRange (ageRange, range) {
	ageRange.ranges = ageRange.ranges.filter((r) => r !== range);
}

onMounted(() => {
	if (props.ageRanges) {
		form.ageRanges = props.ageRanges;
	}
});
</script>

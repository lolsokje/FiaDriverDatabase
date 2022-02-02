<template>
	<h2>General settings</h2>

	<table class="table table-bordered table-dark">
		<thead>
		<tr>
			<th>Setting</th>
			<th>Value</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>Year</td>
			<td class="centered medium">
				<input type="number" v-model="settings.year" class="form-control-sm">
			</td>
			<td class="centered medium">
				<button class="btn btn-primary btn-sm" @click="saveSetting('year')">Save</button>
			</td>
		</tr>
		</tbody>
	</table>
</template>

<script setup>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
	year: {
		type: Number,
		required: true,
	},
});

const settings = reactive({
	year: props.year,
});

function saveSetting (setting) {
	const params = {};
	params[setting] = settings[setting];
	Inertia.post(route('admin.settings.store'), params, { replace: true, preserveState: true });
}
</script>

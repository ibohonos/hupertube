<template>
	<div class="alert-info">
		<h1 class="text-center">User info</h1>
		<table class="table">
			<thead>
				<tr>
					<td>ID</td>
					<td>Login</td>
					<td>First name</td>
					<td>Last name</td>
					<td>Token</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ user.id }}</td>
					<td>{{ user.name }}</td>
					<td>{{ user.first_name }}</td>
					<td>{{ user.last_name }}</td>
					<td>{{ user.api_token }}</td>
				</tr>
			</tbody>
		</table>
		<videos></videos>
		<h2 class="text-center">Videos info</h2>
	</div>
</template>

<script>
	export default {
		props: {
			token: {
				type: String,
				required: true
			}
		},

		 data: function() {
		 	return  {
				user: {},
			 }
		 },

		mounted() {
			axios.get('/api/v2/user?api_token=' + this.token)
				.then(response => {
					this.user = response.data;
				});
		},
	}
</script>

<style scoped>

</style>
<template>
	<div class="alert-info">
		<table class="table">
			<thead>
				<td>Login</td>
				<td>Token</td>
			</thead>
			<tbody>
				<tr>
					<td>{{ users.name }}</td>
					<td>{{ users.api_token }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	export default {
//		 name: "test-a-p-i",
		props: {
			token: {
				type: String,
				required: true
			}
		},

		 data: function() {
		 	return  {
		 		users: {}
			 }
		 },

		mounted() {
			axios.get('/api/user?api_token=' + this.token)
				.then(response => {
					this.users = response.data;
				});
		},
	}
</script>

<style scoped>

</style>
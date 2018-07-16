<template>
	<div class="alert-info">
		<!--{{ // users }}-->
	</div>
</template>

<script>
	export default {
		// name: "test-a-p-i",

		// data: {
		// 	users: []
		// },

		mounted() {
			axios.get('/api/user')
				.then(response => {
					// this.users = response.data;
					console.log(response.data);
				});
		},
	}
</script>

<style scoped>

</style>
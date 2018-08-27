<template v-if="user">
	<div class="row">
		<div class="col-md-4">
			<img :src="user.avatar" height="100%" />
		</div>
		<div class="col-md-8">
			{{ user.first_name }} {{ user.last_name }}
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			user_id: {
				type: Number,
				required: true
			}
		},

		data() {
			return {
				user: {}
			}
		},

		methods: {
			getCommentUser() {
				axios.get('/api/v1/comment/user/' + this.user_id)
					.then(resp => {
						this.user = resp.data.data.user;
					});
			}
		},

		mounted() {
			this.getCommentUser();
		},
	}
</script>

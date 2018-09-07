<template v-if="user">
	<div class="row">
		<div class="col-md-12">
			<a :href="'/user/' + user.id">
				<img :src="user.avatar" class="avatar" style="width: 160px; height: 160px;" />
				<span class="text-center">{{ user.first_name }} {{ user.last_name }}</span>
			</a>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			user_id: {
				type: Number,
				required: true
			},

			user_token: {
				type: String,
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
				axios.get('/api/v2/comment/user/' + this.user_id, {
					params: {
						api_token: this.user_token
					},
				})
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

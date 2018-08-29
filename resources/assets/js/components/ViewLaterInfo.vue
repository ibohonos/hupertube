<template>
	<div v-if="!loader">
		<div v-if="is_view" class="viewed">View later</div>
		<div v-else class="not_view">Not view later</div>
		<a href="#" @click="viewAdd">Add to view later</a>
	</div>
	<div class="loader" v-else></div>
</template>

<script>
	export default {
		props: {
			video_id: {
				type: String,
				required: true
			},

			imdb_id: {
				type: String,
				required: true
			},

			user_token: {
				type: String,
				required: true
			}
		},

		data() {
			return {
				loader: true,
				is_view: false
			}
		},

		methods: {
			isViewMethod() {
				axios.get('/api/v2/is-view-later', {
					params: {
						api_token: this.user_token,
						imdb_id: this.imdb_id,
						video_id: this.video_id
					},
				}).then(resp => {
					if (resp.data.data) {
						this.is_view = true
					}
					this.loader = false;
				});
			},

			viewAdd() {
				axios.post('/api/v2/view-later', {
					api_token: this.user_token,
					imdb_id: this.imdb_id,
					video_id: this.video_id
				}).then(resp => {
					if (resp.data.success) {
						this.is_view = !this.is_view;
					}
				});
			}
		},

		mounted() {
			this.isViewMethod();
		}
	}
</script>

<style scoped>
	.loader {
		border-top: 16px solid blue;
		border-right: 16px solid green;
		border-bottom: 16px solid red;
		border-left: 16px solid pink;
		border-radius: 50%;
		width: 100px;
		height: 100px;
		animation: spin 2s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>

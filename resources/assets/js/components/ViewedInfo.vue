<template>
	<div v-if="!loader" class="film-view-info">

		<div v-if="is_viewed" class="viewed">
			<i class="fab fa-eye"><span> seen</span></i>
			<a @click="viewAdd">
				<i class="fab fa-minus-circle"></i>
			</a>
		</div>
		<div v-else class="not_viewed">
			<i class="fab fa-eye-slash"><span> not seen</span></i>
			<a @click="viewAdd">
				<i class="fab fa-plus-circle"></i>
			</a>
		</div>
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
				is_viewed: false
			}
		},

		methods: {
			isViewedMethod() {
				axios.get('/api/v2/is-viewed', {
					params: {
						api_token: this.user_token,
						imdb_id: this.imdb_id,
						video_id: this.video_id
					},
				}).then(resp => {
					if (resp.data.data) {
						this.is_viewed = true
					}
					this.loader = false;
				});
			},

			viewAdd(e) {
			    e.preventDefault();
				axios.post('/api/v2/viewed', {
					api_token: this.user_token,
					imdb_id: this.imdb_id,
					video_id: this.video_id
				}).then(resp => {
					if (resp.data.success) {
						this.is_viewed = !this.is_viewed;
					}
				});
			}
		},

		mounted() {
			this.isViewedMethod();
		}
	}
</script>

<style scoped>
	.loader {
		border-top: 16px solid #3b5aff;
		border-right: 16px solid #2e93ff;
		border-bottom: 16px solid #24bbff;
		border-left: 16px solid #26dfff;
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

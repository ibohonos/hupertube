<template>
	<div v-if="!loader">
		<div class="row">
			<video-list v-for="video in videos" :key="video.id" :imdb_id="video.imdb_id" :video_id="video.video_id" :user_token="user_token"></video-list>
		</div>
	</div>
	<div class="loader" v-else></div>
</template>

<script>
	export default {
		props: {
			user_token: {
				type: String,
				required: true
			}
		},

		data() {
			return {
				loader: true,
				videos: {}
			}
		},

		methods: {
			isViewMethod() {
				axios.get('/api/v2/all-view-later', {
					params: {
						api_token: this.user_token
					},
				}).then(resp => {
					this.videos = resp.data.data;
					this.loader = false;
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

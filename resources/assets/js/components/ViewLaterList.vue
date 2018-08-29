<template>
	<div v-if="!loader">
		<div class="row">
			<div v-for="video in videos" v-if="video" class="col-md-3">
				<video-list :imdb_id="video.imdb_id" :video_id="video.video_id"></video-list>
			</div>
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

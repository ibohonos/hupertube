<template>
	<div class="row" v-if="!loader">
		<!--<div class="col-md-3" v-for="video in videos.data">-->
			<!--<video-list :imdb_id="video.imdb_id"></video-list>-->
		<!--</div>-->
		<div class="col-md-3" v-for="video in videos.movies" v-if="video">
			<video-list :imdb_id="video.imdb_code" :video_id="video.id"></video-list>
		</div>
	</div>
	<div class="loader mx-auto" v-else></div>
</template>

<script>
	export default {
		data() {
			return  {
				videos: {},
				loader: true,
			}
		},

		methods: {
			getAllVideos() {
				axios.get('https://yts.am/api/v2/list_movies.json?limit=30&page=1')
					.then(response => {
						this.videos = response.data.data;
						this.loader = false;
					});
			}
		},
		mounted() {
			this.getAllVideos();
//			axios.get('https://yts.am/api/v2/list_movies.json?limit=50&page=1')
//				.then(response => {
//					this.videos = response.data.data;
//				});
			// axios.get('https://eztv.ag/api/get-torrents?limit=30&page=2')
			// 	.then(response => {
			// 		this.videos = response.data;
			// 	});
			// axios.get('/api/v1/videos?page=379')
			// 	.then(resp => {
			// 		this.videos = resp.data.data;
			// 	});
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
		width: 150px;
		height: 150px;
		animation: spin 2s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>

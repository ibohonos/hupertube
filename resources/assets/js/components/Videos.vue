<template>
	<div class="row" v-if="videos">
		<!--<div class="col-md-3" v-for="video in videos.data">-->
			<!--<video-list :imdb_id="video.imdb_id"></video-list>-->
		<!--</div>-->
		<div class="col-md-3" v-for="video in videos.movies" v-if="video">
			<video-list :imdb_id="video.imdb_code"></video-list>
		</div>
	</div>
</template>

<script>
	export default {
		data: function() {
			return  {
				videos: {}
			}
		},

		mounted() {
			axios.get('https://yts.am/api/v2/list_movies.json?limit=50&page=1')
				.then(response => {
					this.videos = response.data.data;
				});
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

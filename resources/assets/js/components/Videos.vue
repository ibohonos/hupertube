<template>
	<div class="row">
		<div class="col-md-3" v-for="video in videos.movies">
			<a :href="'/video/' + video.id"><img :src="video.large_cover_image" width="100%"></a>
			<h3><a :href="'/video/' + video.id">{{ video.title }}</a></h3>
			<!--<p>{{ video.synopsis }}</p>-->
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
//			axios.get('https://yts.am/api/v2/list_movies.json?limit=20&page=2')
//				.then(response => {
//					this.videos = response.data.data;
//					console.log(response.data);
//				});
			// axios.get('https://eztv.ag/api/get-torrents?limit=30&page=2')
			// 	.then(response => {
			// 		this.videos = response.data;
			// 		console.log(response.data);
			// 	});
			axios.get('http://www.omdbapi.com/?apikey=54349d34')
				.then(resp => {
					this.videos = resp.data;
					console.log(this.videos);
				});
		}
	}
</script>

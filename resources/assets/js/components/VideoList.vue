<template>
	<div>
		<a :href="'/video/' + imdb_id">
			<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%" v-if="video.poster_path">
			<h2>{{ video.title }}</h2>
		</a>
		<!--{{ video }}-->
	</div>
</template>

<script>
	export default {
		props: {
			imdb_id: {
				type: String,
				required: true
			}
		},

		data: function() {
			return  {
				video: {},
				api_key: 'e4649c026a8d8a3c93ed840286816339',
				// lang: 'en_US',
				lang: 'ru_RU',
				// lang: 'uk_UA',
			}
		},

		mounted() {
			// axios.get('https://api.themoviedb.org/3/movie/tt' + this.imdb_id + '?api_key=' + this.api_key + '&language=' + this.lang)
			// 	.then(response => {
			// 		this.video = response.data;
			// 		console.log(this.video);
			// 	});
			axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id + '?api_key=' + this.api_key + '&language=' + this.lang)
				.then(response => {
					this.video = response.data;
				});
		}
	}
</script>
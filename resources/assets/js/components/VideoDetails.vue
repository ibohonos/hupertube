<template>
	<div class="row">
		<div class="col-md-12">
			<h1 class="text-center">{{ video.title }}</h1>
		</div>
		<div class="col-md-4">
			<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%">
		</div>
		<div class="col-md-8">
			<p>{{ video.overview }}</p>
			<p>IMDb: {{ all.rating }}</p>
			<p>Дата релізу: {{ video.release_date }}</p>
			<span>Жанр:</span>
			<div v-for="janr in all.genres">
				<span>{{ janr }}</span>
			</div>
			<span>Якість:</span>
			<div v-for="torrent in all.torrents">
				<a :href="torrent.url">{{ torrent.quality }}</a>
			</div>
			<div v-if="tr_length">
				<p>Trailers ({{ tr_length }}):</p>
				<div class="trailers" v-for="trailer in trailers.results">
					<iframe width="560" height="315" :src="'https://www.youtube.com/embed/' + trailer.key" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			all: {
				type: Object,
				required: true
			}
		},

		data: function() {
			return  {
				video: {},
				api_key: 'e4649c026a8d8a3c93ed840286816339',
				trailers: {},
				tr_length: ''
			}
		},

		mounted() {
			axios.get('https://api.themoviedb.org/3/movie/' + this.all.imdb_code + '?api_key=' + this.api_key + '&language=uk_UA')
				.then(response => {
					this.video = response.data;
				});
			axios.get('https://api.themoviedb.org/3/movie/' + this.all.imdb_code + '/videos?api_key=' + this.api_key + '&language=uk_UA')
				.then(resp => {
					this.trailers = resp.data;
					this.tr_length = this.trailers.results.length;
				});
		}
	}
</script>

<style scoped>

</style>
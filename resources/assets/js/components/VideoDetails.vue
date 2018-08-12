<template>
	<div class="row">
		<div class="col-md-12">
			<h1 class="text-center">{{ video.title }}</h1>
		</div>
		<div class="col-md-4">
			<img :src="'https://image.tmdb.org/t/p/w1280' + video.poster_path" width="100%">
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
			<div v-if="all.yt_trailer_code">
				<p>Трейлер:</p>
				<iframe width="560" height="315" :src="'https://www.youtube.com/embed/' + all.yt_trailer_code" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
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
				api_key: 'e4649c026a8d8a3c93ed840286816339'
			}
		},

		mounted() {
			axios.get('https://api.themoviedb.org/3/find/' + this.all.imdb_code + '?api_key=' + this.api_key + '&external_source=imdb_id&language=ru_RU')
				.then(response => {
					this.video = response.data.movie_results[0];
					console.log(this.video);
				});
		}
	}
</script>

<style scoped>

</style>
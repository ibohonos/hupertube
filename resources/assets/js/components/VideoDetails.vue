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
			<p>
				<span>Rating: </span>
				<span class="imdbRatingPlugin" data-user="ur91229543" :data-title="'tt' + imdb_id" data-style="p4">
					<a :href="'https://www.imdb.com/title/tt' + imdb_id + '/?ref_=plg_rt_1'" target="_blank">
						<img src="https://ia.media-imdb.com/images/G/01/imdb/plugins/rating/images/imdb_37x18.png" alt="video.title" />
					</a>
				</span>
			</p>
			<p>Дата релізу: {{ video.release_date }}</p>
			<!--<span>Жанр:</span>-->
			<!--<div v-for="janr in all.genres">-->
				<!--<span>{{ janr }}</span>-->
			<!--</div>-->
			<!--<span>Якість:</span>-->
			<!--<div v-for="torrent in all.torrents">-->
				<!--<a :href="torrent.url">{{ torrent.quality }}</a>-->
			<!--</div>-->
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
	(function(d, s, id) {
		var js, stags = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)){
			return;
		}
		js = d.createElement(s);
		js.id = id;
		js.src = "https://ia.media-imdb.com/images/G/01/imdb/plugins/rating/js/rating.js";
		stags.parentNode.insertBefore(js,stags);
	})(document, "script", "imdb-rating-api");
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
				trailers: {},
				tr_length: ''
			}
		},

		mounted() {
			axios.get('https://api.themoviedb.org/3/movie/tt' + this.imdb_id + '?api_key=' + this.api_key + '&language=ru_RU')
				.then(response => {
					this.video = response.data;
				});
			axios.get('https://api.themoviedb.org/3/movie/tt' + this.imdb_id + '/videos?api_key=' + this.api_key + '&language=ru_RU')
				.then(resp => {
					this.trailers = resp.data;
					this.tr_length = this.trailers.results.length;
				});
		}
	}
</script>

<style scoped>

</style>
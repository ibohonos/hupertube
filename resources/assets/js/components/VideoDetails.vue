<template>
	<div class="row" v-if="video">
		<div class="col-md-12">
			<h1 class="text-center">{{ video.title }}</h1>
		</div>
		<div class="col-md-4" v-if="video.poster_path">
			<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%">
		</div>
		<div class="col-md-4" v-else>
			<div class="loader mx-auto"></div>
		</div>
		<div class="col-md-8">
			<p v-if="video.overview">{{ video.overview }}</p>
			<p v-else>{{ video_en.overview }}</p>
			<p>
				<span>Rating: </span>
				<!--<span class="imdbRatingPlugin" data-user="ur91229543" :data-title="'tt' + imdb_id" data-style="p4">-->
					<!--<a :href="'https://www.imdb.com/title/tt' + imdb_id + '/?ref_=plg_rt_1'" target="_blank">-->
						<!--<img src="https://ia.media-imdb.com/images/G/01/imdb/plugins/rating/images/imdb_37x18.png" alt="video.title" />-->
					<!--</a>-->
				<!--</span>-->
				<span class="imdbRatingPlugin" data-user="ur91229543" :data-title="'' + imdb_id" data-style="p4">
					<a :href="'https://www.imdb.com/title/' + imdb_id + '/?ref_=plg_rt_1'" target="_blank">
						<img src="https://ia.media-imdb.com/images/G/01/imdb/plugins/rating/images/imdb_37x18.png" alt="video.title" />
					</a>
				</span>
			</p>
			<p>Release date: {{ video.release_date }}</p>
			<span>Genres:</span>
			<!--<div v-for="janr in genres">-->
				<!--<span>{{ janr }}</span>-->
			<!--</div>-->
			<!--<div v-for="janr in video.genres">-->
				<span v-for="janr in video.genres">{{ janr.name }} </span>
			<!--</div>-->
			<br/>
			<span>Quality:</span>
			<!--<div v-for="torrent in torrents">-->
				<a v-for="torrent in torrents" :href="torrent.url" class="torrent_quality">{{ torrent.quality }}</a>
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
		let js, stags = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
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
			},
			video_id: {
				type: String,
				required: true
			}
		},

		data() {
			return  {
				video: {},
				video_en: {},
				api_key: 'e4649c026a8d8a3c93ed840286816339',
				trailers: {},
				tr_length: '',
				torrents: {},
//				lang: 'en_US',
//				lang: 'uk_UA',
				lang: 'ru_RU',
			}
		},

		methods: {
			getVideoTrailers() {
				axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id + '/videos?api_key=' + this.api_key + '&language=' + this.lang)
					.then(resp => {
						this.trailers = resp.data;
						this.tr_length = this.trailers.results.length;
					});
			},
			getVideoInfo() {
				axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id + '?api_key=' + this.api_key + '&language=' + this.lang)
					.then(response => {
						this.video = response.data;
						if (!this.video.overview) {
							this.getVideoEnInfo();
						}
					});
			},
			getVideoEnInfo() {
				axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id + '?api_key=' + this.api_key + '&language=en_US')
					.then(response => {
						this.video_en = response.data;
					});
			},
			getAllVideoDetails() {
				axios.get('https://yts.am/api/v2/movie_details.json?movie_id=' + this.video_id)
					.then(resp => {
						this.torrents = resp.data.data.movie.torrents;
					});
			}
		},

		mounted() {
			this.getVideoInfo();
			this.getVideoTrailers();
			this.getAllVideoDetails();
		},

//		mounted() {
//			// axios.get('https://api.themoviedb.org/3/movie/tt' + this.imdb_id + '?api_key=' + this.api_key + '&language=' + this.lang)
//			// 	.then(response => {
//			// 		this.video = response.data;
//			// 	});
//			// axios.get('https://api.themoviedb.org/3/movie/tt' + this.imdb_id + '/videos?api_key=' + this.api_key + '&language=' + this.lang)
//			// 	.then(resp => {
//			// 		this.trailers = resp.data;
//			// 		this.tr_length = this.trailers.results.length;
//			// 	});
//			axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id + '?api_key=' + this.api_key + '&language=' + this.lang)
//				.then(response => {
//					this.video = response.data;
//				});
//			axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id + '/videos?api_key=' + this.api_key + '&language=' + this.lang)
//				.then(resp => {
//					this.trailers = resp.data;
//					this.tr_length = this.trailers.results.length;
//				});
//		}
	}
</script>

<style scoped>
	.loader {
		border-top: 16px solid blue;
		border-right: 16px solid green;
		border-bottom: 16px solid red;
		border-left: 16px solid pink;
		border-radius: 50%;
		width: 120px;
		height: 120px;
		animation: spin 2s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}

	.torrent_quality {
		margin: 0 5px 0 0;
	}
</style>
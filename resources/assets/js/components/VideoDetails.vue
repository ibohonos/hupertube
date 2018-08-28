<template>
	<div class="row" v-if="video">
		<div class="col-md-12">
			<h1 class="text-center">{{ video.title }}</h1>
		</div>
		<div class="col-md-4" v-if="video.poster_path">
			<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%">
			<viewed :video_id="video_id" :imdb_id="imdb_id" :user_token="user_token"></viewed>
		</div>
		<div class="col-md-4" v-else>
			<div class="loader mx-auto"></div>
		</div>
		<div class="col-md-8">
			<p v-if="video.overview">{{ video.overview }}</p>
			<p v-else>{{ video_en.overview }}</p>
			<h3>{{ $lang.video_details.rating }}:</h3>
			<p>
				<span class="imdbRatingPlugin" data-user="ur91229543" :data-title="'' + imdb_id" data-style="p4">
					<a :href="'https://www.imdb.com/title/' + imdb_id + '/?ref_=plg_rt_1'" target="_blank">
						<img src="https://ia.media-imdb.com/images/G/01/imdb/plugins/rating/images/imdb_37x18.png" alt="video.title" />
					</a>
				</span>
			</p>
			<h3>{{ $lang.video_details.release }}:</h3>
			<span>{{ video.release_date }}</span>
			<h3>{{ $lang.video_details.run_time }}:</h3>
			<span>{{ video.runtime }}</span>
			<h3>{{ $lang.video_details.genres }}:</h3>
			<span v-for="janr in video.genres">{{ janr.name }} </span>
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">{{ $lang.video_details.actors }}</h3>
				</div>
				<div class="col-md-2" v-for="(actor, index) in credits.cast" v-if="index < 6">
					<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + actor.profile_path" width="100%" v-if="actor.profile_path">
					<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>
					<p>{{ actor.name }}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">{{ $lang.video_details.cast }}</h3>
				</div>
				<div class="col-md-2" v-for="(cast, index) in credits.crew" v-if="index < 6">
					<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + cast.profile_path" width="100%" v-if="cast.profile_path">
					<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>
					<h5>{{ cast.job }}</h5>
					<p>{{ cast.name }}</p>
				</div>
			</div>
			<h3>{{ $lang.video_details.quality }}:</h3>
			<a v-for="torrent in torrents" :href="torrent.url" class="torrent_quality">{{ torrent.quality }}</a>
			<div v-if="tr_length">
				<h3>{{ $lang.video_details.trailers }} ({{ tr_length }}):</h3>
				<div class="trailers" v-for="trailer in trailers.results">
					<iframe width="560" height="315" :src="'https://www.youtube.com/embed/' + trailer.key" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<h3 class="text-center">{{ $lang.video_details.comments }}:</h3>
			<comments :imdb_id="imdb_id"></comments>
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
			},

			user_token: {
				type: String,
				required: true
			}
		},

		data() {
			return {
				video: {},
				video_en: {},
				api_key: 'e4649c026a8d8a3c93ed840286816339',
				trailers: {},
				tr_length: '',
				credits: {},
				torrents: {},
				lang: native_lang,
			}
		},

		methods: {
			getVideoTrailers() {
				axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id + '/videos', {
					params: {
						api_key: this.api_key,
						language: this.lang,
					},
				}).then(resp => {
						this.trailers = resp.data;
						this.tr_length = this.trailers.results.length;
					});
			},
			getVideoInfo() {
				axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id, {
					params: {
						api_key: this.api_key,
						language: this.lang,
					},
				}).then(response => {
						this.video = response.data;
						if (!this.video.overview) {
							this.getVideoEnInfo();
						}
					});
			},
			getVideoEnInfo() {
				axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id, {
					params: {
						api_key: this.api_key,
						language: 'en_US',
					},
				}).then(response => {
						this.video_en = response.data;
					});
			},
			getAllVideoDetails() {
				axios.get('https://yts.am/api/v2/movie_details.json', {
					params: {
						movie_id: this.video_id,
					},
				})
					.then(resp => {
						this.torrents = resp.data.data.movie.torrents;
					});
			},
			getVideoCredits() {
				axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id + '/credits', {
					params: {
						api_key: this.api_key,
						language: this.lang,
					},
				}).then(resp => {
						this.credits = resp.data;
					});
			}
		},

		mounted() {
			this.$lang.setLang(currentLang);
			this.getVideoInfo();
			this.getVideoTrailers();
			this.getAllVideoDetails();
			this.getVideoCredits();
		},
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
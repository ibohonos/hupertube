<template>
	<div class="row film-details" v-if="video">
		<div class="col-12">
			<div class="overlay">
				<img class="background-img" :src="'https://image.tmdb.org/t/p/w1400_and_h450_face/' + video.backdrop_path" width="100%">
			</div>
			<div class="row film-desc">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4" v-if="video.poster_path">
							<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%">
							<div class="film-icons-info">
								<viewed :video_id="video_id" :imdb_id="imdb_id" :user_token="user_token"></viewed>
								<view-later :video_id="video_id" :imdb_id="imdb_id" :user_token="user_token"></view-later>
							</div>
						</div>
						<div class="col-md-4" v-else>
							<div class="loader mx-auto"></div>
						</div>
						<div class="col-md-8">
							<h1 class="text-center">{{ video.title }}</h1>
							<p class="desc" v-if="video.overview">{{ video.overview }}</p>
							<p v-else>{{ video_en.overview }}</p>
							<ul>
								<li>
									<h3>{{ $lang.video_details.rating }}:</h3>
									<span class="imdbRatingPlugin" data-user="ur91229543" :data-title="'' + imdb_id" data-style="p4">
										<a :href="'https://www.imdb.com/title/' + imdb_id + '/?ref_=plg_rt_1'" target="_blank">
											<img src="https://ia.media-imdb.com/images/G/01/imdb/plugins/rating/images/imdb_37x18.png" alt="video.title" />
										</a>
									</span>
								</li>
								<li>
									<h3>{{ $lang.video_details.release }}:</h3>
									<span>{{ video.release_date }}</span>
								</li>
								<li>
									<h3>{{ $lang.video_details.run_time }}:</h3>
									<span>{{ video.runtime }} min</span>
								</li>
								<li>
									<h3>{{ $lang.video_details.genres }}:</h3>
									<span v-for="janr in video.genres">{{ janr.name }} </span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="row film-extra">
				<div class="col-md-12">
					<h1 class="text-center">{{ $lang.video_details.actors }}</h1>
				</div>
				<div class="col-md-2" v-for="(actor, index) in credits.cast" v-if="index < 6">
					<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + actor.profile_path" width="100%" v-if="actor.profile_path">
					<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>
					<p>{{ actor.name }}</p>
				</div>
			</div>
			<div class="row film-extra">
				<div class="col-md-12">
					<h1 class="text-center">{{ $lang.video_details.cast }}</h1>
				</div>
				<div class="col-md-2" v-for="(cast, index) in credits.crew" v-if="index < 6">
					<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + cast.profile_path" width="100%" v-if="cast.profile_path">
					<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>
					<h5>{{ cast.job }}</h5>
					<p>{{ cast.name }}</p>
				</div>
			</div>
			<div class="row film-watch">
				<div class="col-md-12">
					<h1 class="text-center">Watch online</h1>
				</div>
				<div class="col-md-12">
					<div class="accordion" id="accordionExample">
						<div class="card">
							<div class="card-header" id="headingOne">
								<h5 class="mb-0">
									<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										Watch film online
									</button>
								</h5>
							</div>

							<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
								<div class="card-body">
									<h4>Choose quality: </h4>
									<button v-for="(torrent, index) in torrents" @click="send_file(torrent.url, torrent.quality)" class="btn btn-info torrent_quality" v-if="index < 3">{{ torrent.quality }}</button>
									<p>player</p>




									<!--<plyr-video v-if="this.videos[0].src" :videos="this.videos[0].src" :crossorigin="true" />-->

									<!--<plyr v-if="video_link">-->
										<!--<video>-->
											<!--<source :src="video_link" type="video/mp4" />-->
											<!--&lt;!&ndash;<source src="video.ogg" type="video/ogg" />&ndash;&gt;-->
										<!--</video>-->
									<!--</plyr>-->

									<vue-plyr v-if="video_link">
										<video :src="video_link">
											<source :src="video_link" type="video/mp4" size="720">
											<!--<source src="video-1080p.mp4" type="video/mp4" size="1080">-->
											<track v-if="subtitle" kind="captions" :label="short_lang" :srclang="short_lang" :src="subtitle" default>
										</video>
									</vue-plyr>

									<!--<video controls v-if="video_link" style="width: 100%;">-->
								        <!--<source :src="video_link" type="video/mp4"/>-->
		<!--&lt;!&ndash; 						        <source src="movie.webm" type="video/webm"/>-->
								        <!--<source src="movie.ogg" type="video/ogg"/> &ndash;&gt;-->
								        <!--&lt;!&ndash; fallback &ndash;&gt;-->
								        <!--Your browser does not support the <code>video</code> element.-->
								    <!--</video>-->
								</div>


								
								<!--<div class="card-body" v-else>-->
									<!--<h4>Choose quality: </h4>-->
									<!--<button v-for="(torrent, index) in torrents" @click="send_file(torrent.url, torrent.quality)" class="btn btn-info torrent_quality" v-if="index < 2">{{ torrent.quality }}</button>-->
									<!--<p>player</p>-->
								<!--</div>-->
							</div>
						</div>
						<div class="card">
							<div class="card-header" id="headingTwo">
								<h5 class="mb-0">
									<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										Watch trailers
									</button>
								</h5>
							</div>
							<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
								<div class="card-body">
									<div v-if="tr_length">
										<h3 class="text-center">{{ $lang.video_details.trailers }} ({{ tr_length }}):</h3>
										<div class="text-center trailers" v-for="trailer in trailers.results">
											<iframe width="560" height="315" :src="'https://www.youtube.com/embed/' + trailer.key" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
										</div>
									</div>
									<div v-else>
										No trailers available
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row film-comments">
				<div class="col-md-12">
					<h1 class="text-center">{{ $lang.video_details.comments }}</h1>
					<comments :imdb_id="imdb_id" :user_token="user_token"></comments>
				</div>
			</div>
		</div>




	</div>
</template>


<script>
	import 'vue-plyr';
	import 'vue-plyr/dist/vue-plyr.css';

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
				type: Number,
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
				short_lang: short_lang,
				server_link: "http://localhost:3000",
				video_link: "",
				subtitle: "",
//				videos: [
//					{ src: '', format: 'mp4' }
////					{ src: 'path/to/video.webm', format: 'webm' }
//				],
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
			},

			send_file(url, quality) {
				axios.post(this.server_link + '/movie/' + this.imdb_id + '/' + this.short_lang + '/1', {
					torrent_link: url,
				}).then(resp => {
//					console.log(resp);
//					this.videos[0].src = resp.data.src;
					this.video_link = resp.data.src;
					this.subtitle = '/movies/' + this.imdb_id + '/' + this.short_lang + '.vtt';
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
		border-top: 16px solid #3b5aff;
		border-right: 16px solid #2e93ff;
		border-bottom: 16px solid #24bbff;
		border-left: 16px solid #26dfff;
		border-radius: 50%;
		width: 100px;
		height: 100px;
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
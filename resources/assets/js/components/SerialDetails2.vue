<template>
	<div class="film-details">
		<div class="row" v-if="video">
			<div class="col-12">
				<div class="overlay" v-if="video.backdrop_path">
					<img class="background-img" :src="'https://image.tmdb.org/t/p/w1400_and_h450_face/' + video.backdrop_path" width="100%">
				</div>
				<div class="row film-desc">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4" v-if="video.poster_path">
								<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%">
								<div class="film-icons-info" v-if="user_token !== 'Null'">
									<viewed video_type="serials" :imdb_id="imdb_id" :user_token="user_token"></viewed>
									<view-later video_type="serials" :imdb_id="imdb_id" :user_token="user_token"></view-later>
								</div>
							</div>
							<div class="col-md-4" v-else>
								<div class="loader mx-auto"></div>
							</div>
							<div class="col-md-8">
								<h1 class="text-center">{{ video.name }}</h1>
								<p class="desc" v-if="video.overview">{{ video.overview }}</p>
								<p v-else>{{ video_en.overview }}</p>
								<ul>
									<li>
										<h3>{{ $lang.video_details.rating }}:</h3>
										<span>{{ video.vote_average }}</span>
										<!--<span class="imdbRatingPlugin" data-user="ur91229543" :data-title="'' + imdb_id" data-style="p4">-->
											<!--<a :href="'https://www.imdb.com/title/' + imdb_id + '/?ref_=plg_rt_1'" target="_blank">-->
												<!--<img src="https://ia.media-imdb.com/images/G/01/imdb/plugins/rating/images/imdb_37x18.png" alt="video.title" />-->
											<!--</a>-->
										<!--</span>-->
									</li>
									<li>
										<h3>{{ $lang.video_details.release }}:</h3>
										<span>{{ video.first_air_date }}</span>
									</li>
									<li>
										<h3>Seasons:</h3>
										<span>{{ kodik_resp[0].last_season }}</span>
									</li>
									<li>
										<h3>Episodes:</h3>
										<span>{{ kodik_resp[0].last_episode }} </span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<!--<div class="row film-extra">-->
					<!--<div class="col-md-12">-->
						<!--<h1 class="text-center">{{ $lang.video_details.actors }}</h1>-->
					<!--</div>-->
					<!--<div class="col-md-2" v-for="(actor, index) in credits.cast" v-if="index < 6">-->
						<!--<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + actor.profile_path" width="100%" v-if="actor.profile_path">-->
						<!--<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>-->
						<!--<p>{{ actor.name }}</p>-->
					<!--</div>-->
				<!--</div>-->
				<!--<div class="row film-extra">-->
					<!--<div class="col-md-12">-->
						<!--<h1 class="text-center">{{ $lang.video_details.cast }}</h1>-->
					<!--</div>-->
					<!--<div class="col-md-2" v-for="(cast, index) in credits.crew" v-if="index < 6">-->
						<!--<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + cast.profile_path" width="100%" v-if="cast.profile_path">-->
						<!--<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>-->
						<!--<h5>{{ cast.job }}</h5>-->
						<!--<p>{{ cast.name }}</p>-->
					<!--</div>-->
				<!--</div>-->
				<div class="row film-watch">
					<div class="col-md-12">
						<h1 class="text-center">{{ $lang.video_details.watch }}</h1>
					</div>
					<div class="col-md-12">
						<div class="accordion" id="accordionExample">
							<div class="card">
								<div class="card-header" id="headingOne">
									<h5 class="mb-0">
										<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											{{ $lang.video_details.watch_film }}
										</button>
									</h5>
								</div>

								<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
									<div class="card-body">
										<iframe :src="kodik_resp[0].link" width="100%" height="480" frameborder="0" allowfullscreen></iframe>
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

		<div class="row" v-else-if="kodik_resp">
			<div class="col-12">
				<div class="overlay">
					<img class="background-img" src="https://www.tpv.com/wp-content/uploads/2016/02/salestpv-video-header-poster.jpg" width="100%">
				</div>
				<div class="row film-desc">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4">
								<img src="http://oldquarteracousticcafe.com/wp-content/uploads/2018/07/Copy-of-Event-Flyer-TEmplate-Made-with-PosterMyWall-44.jpg" width="100%">
								<div class="film-icons-info" v-if="user_token !== 'Null'">
									<viewed video_type="serials" :imdb_id="imdb_id" :user_token="user_token"></viewed>
									<view-later video_type="serials" :imdb_id="imdb_id" :user_token="user_token"></view-later>
								</div>
							</div>
							<div class="col-md-8">
								<h1 class="text-center">{{ kodik_resp[0].title }}</h1>
								<ul>
									<li>
										<h3>{{ $lang.video_details.release }}:</h3>
										<span>{{ kodik_resp[0].year }}</span>
									</li>
									<li v-if="kodik_resp[0].last_season">
										<h3>Seasons:</h3>
										<span>{{ kodik_resp[0].last_season }}</span>
									</li>
									<li>
										<h3>Episodes:</h3>
										<span>{{ kodik_resp[0].last_episode }} </span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<!--<div class="row film-extra">-->
				<!--<div class="col-md-12">-->
				<!--<h1 class="text-center">{{ $lang.video_details.actors }}</h1>-->
				<!--</div>-->
				<!--<div class="col-md-2" v-for="(actor, index) in credits.cast" v-if="index < 6">-->
				<!--<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + actor.profile_path" width="100%" v-if="actor.profile_path">-->
				<!--<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>-->
				<!--<p>{{ actor.name }}</p>-->
				<!--</div>-->
				<!--</div>-->
				<!--<div class="row film-extra">-->
				<!--<div class="col-md-12">-->
				<!--<h1 class="text-center">{{ $lang.video_details.cast }}</h1>-->
				<!--</div>-->
				<!--<div class="col-md-2" v-for="(cast, index) in credits.crew" v-if="index < 6">-->
				<!--<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + cast.profile_path" width="100%" v-if="cast.profile_path">-->
				<!--<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>-->
				<!--<h5>{{ cast.job }}</h5>-->
				<!--<p>{{ cast.name }}</p>-->
				<!--</div>-->
				<!--</div>-->
				<div class="row film-watch">
					<div class="col-md-12">
						<h1 class="text-center">{{ $lang.video_details.watch }}</h1>
					</div>
					<div class="col-md-12">
						<div class="accordion" id="accordionExample">
							<div class="card">
								<div class="card-header" id="headingOne">
									<h5 class="mb-0">
										<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											{{ $lang.video_details.watch_film }}
										</button>
									</h5>
								</div>

								<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
									<div class="card-body">
										<iframe :src="kodik_resp[0].link" width="100%" height="480" frameborder="0" allowfullscreen></iframe>
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
		<a href="javascript:" id="return-to-top" @click="scrollToTop"><i class="fa fa-arrow-up"></i></a>
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
				tr_length: '',
				credits: {},
				lang: native_lang,
				short_lang: short_lang,
				server_link: "http://localhost:3000",
				video_link: "",
				subtitles: {},
				show_btn: true,
				video_preloader: true,
				kodik_api: "91cda3daa53978fdc025304879980c89",
				kodik_url: "https://kodikapi.com/",
				kodik_resp: {}
			}
		},

		methods: {
			getVideoInfo() {
				axios.get('https://api.themoviedb.org/3/find/' + this.imdb_id, {
					params: {
						api_key: this.api_key,
						language: this.lang,
						external_source: 'imdb_id'
					},
				}).then(response => {
						this.video = response.data.tv_results[0];
						if (!this.video.overview) {
							this.getVideoEnInfo();
						}
					});
			},
			getVideoEnInfo() {
				axios.get('https://api.themoviedb.org/3/find/' + this.imdb_id, {
					params: {
						api_key: this.api_key,
						language: 'en_US',
						external_source: 'imdb_id'
					},
				}).then(response => {
					console.log(response);
						this.video_en = response.data.tv_results[0];
					});
			},
			// getVideoCredits() {
			// 	axios.get('https://api.themoviedb.org/3/find/' + this.imdb_id + '/credits', {
			// 		params: {
			// 			api_key: this.api_key,
			// 			language: this.lang,
			// 		},
			// 	}).then(resp => {
			// 			this.credits = resp.data;
			// 		});
			// },

			getVideoPlayer() {
				if (this.imdb_id.substr(0, 2) === "tt") {
					axios.get(this.kodik_url + 'search', {
						params: {
							imdb_id: this.imdb_id,
							token: this.kodik_api,
						},
					}).then(resp => {
						this.kodik_resp = resp.data.results;
					});
				} else {
					axios.get(this.kodik_url + 'search', {
						params: {
							title: this.imdb_id,
							token: this.kodik_api,
						},
					}).then(resp => {
						this.kodik_resp = resp.data.results;
					});
				}
			},

			scrollToTop() {
				$('body,html').animate({
					scrollTop : 0				// Scroll to top of body
				}, 500);
			}
		},

		mounted() {
			this.$lang.setLang(currentLang);
			this.getVideoInfo();
			// this.getVideoCredits();
			this.getVideoPlayer();
			$(window).scroll(function() {
				if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
					$('#return-to-top').fadeIn(200);    // Fade in the arrow
				} else {
					$('#return-to-top').fadeOut(200);   // Else fade out the arrow
				}
			});
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

	#return-to-top {
		position: fixed;
		bottom: 20px;
		right: 20px;
		background: rgb(0, 0, 0);
		background: rgba(0, 0, 0, 0.7);
		width: 50px;
		height: 50px;
		display: block;
		text-decoration: none;
		-webkit-border-radius: 35px;
		-moz-border-radius: 35px;
		border-radius: 35px;
		display: none;
		-webkit-transition: all 0.3s linear;
		-moz-transition: all 0.3s ease;
		-ms-transition: all 0.3s ease;
		-o-transition: all 0.3s ease;
		transition: all 0.3s ease;
	}
	#return-to-top i {
		color: #fff;
		margin: 0;
		position: relative;
		left: 16px;
		top: 13px;
		font-size: 19px;
		-webkit-transition: all 0.3s ease;
		-moz-transition: all 0.3s ease;
		-ms-transition: all 0.3s ease;
		-o-transition: all 0.3s ease;
		transition: all 0.3s ease;
	}
	#return-to-top:hover {
		background: rgba(0, 0, 0, 0.9);
	}
	#return-to-top:hover i {
		color: #fff;
		top: 5px;
	}
</style>
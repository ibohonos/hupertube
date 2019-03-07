<template>
	<div class="row film-details" v-if="video">
		<div class="col-12">
			<div class="overlay">
				<img v-if="video.backdrop_path" class="background-img" :src="'https://image.tmdb.org/t/p/w1400_and_h450_face/' + video.backdrop_path" width="100%">
				<img v-else class="background-img" src="https://www.tpv.com/wp-content/uploads/2016/02/salestpv-video-header-poster.jpg" width="100%">
			</div>
			<div class="row film-desc">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							<img v-if="video.poster_path" :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%">
							<img v-else src="http://oldquarteracousticcafe.com/wp-content/uploads/2018/07/Copy-of-Event-Flyer-TEmplate-Made-with-PosterMyWall-44.jpg" width="100%">
							<div class="film-icons-info" v-if="user_token !== 'Null'">
								<viewed video_type="films" :imdb_id="'' + video.id" :user_token="user_token"></viewed>
								<view-later video_type="films" :imdb_id="'' + video.id" :user_token="user_token"></view-later>
							</div>
						</div>
						<div class="col-md-8">
							<h1 class="text-center">{{ video.name }}</h1>
							<p class="desc" v-if="video.overview">{{ video.overview }}</p>
							<p v-else>{{ video_en.overview }}</p>
							<ul>
								<li v-if="kodik_resp && kodik_resp[0]">
									<h3>{{ $lang.videos.quality }}:</h3>
									<span>{{ kodik_resp[0].quality }}</span>
								</li>
								<li>
									<h3>{{ $lang.video_details.rating }}:</h3>
									<span>{{ video.vote_average }}/10</span>
								</li>
								<li>
									<h3>{{ $lang.video_details.release }}:</h3>
									<span>{{ video.first_air_date }}</span>
								</li>
								<li>
									<h3>{{ $lang.video_details.genres }}:</h3>
									<span v-for="janr in video.genres">{{ janr.name }} </span>
								</li>
								<!--<li v-if="video.production_companies">-->
								<!--<h3>{{ $lang.video_details.companies }}:</h3>-->
								<!--<span v-for="company in video.production_companies">{{ company.name }}, </span>-->
								<!--</li>-->
								<li v-if="video.production_countries">
									<h3>{{ $lang.video_details.countries }}:</h3>
									<span v-for="company in video.production_countries">{{ company.name }}, </span>
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
				<carousel :navigationEnabled="true" :scrollPerPage="false" :perPageCustom="[[480, 2], [768, 3], [1080, 4]]" class="col-md-10 offset-md-1">
					<slide v-for="(actor, index) in credits.cast" :key="actor.id">
						<a :href="'/persone/' + actor.id">
							<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + actor.profile_path" width="100%" v-if="actor.profile_path">
							<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>
							<h5>{{ actor.name }}</h5>
							<h6>{{ actor.character }}</h6>
						</a>
					</slide>
				</carousel>
			</div>
			<div class="row film-extra">
				<div class="col-md-12">
					<h1 class="text-center">{{ $lang.video_details.cast }}</h1>
				</div>
				<carousel :navigationEnabled="true" :scrollPerPage="false" :perPageCustom="[[480, 2], [768, 3], [1080, 4]]" class="col-md-10 offset-md-1">
					<slide v-for="(cast, index) in credits.crew" :key="cast.id" style="padding: 0 5px;">
						<a :href="'/persone/' + cast.id">
							<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + cast.profile_path" width="100%" v-if="cast.profile_path">
							<img src="/storage/avatars/default_actors.jpg" width="100%" v-else>
							<h5>{{ cast.name }}</h5>
							<h6>{{ cast.job }}</h6>
						</a>
					</slide>
				</carousel>
			</div>
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
									<iframe v-if="kodik_resp && kodik_resp[0]" :src="kodik_resp[0].link" width="100%" height="480" frameborder="0" allowfullscreen></iframe>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header" id="headingTwo">
								<h5 class="mb-0">
									<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										{{ $lang.video_details.watch_trailers }}
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
										{{ $lang.video_details.no_trailers }}
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


		<a href="javascript:" id="return-to-top" @click="scrollToTop"><i class="fa fa-arrow-up"></i></a>


	</div>
</template>


<script>
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
				trailers: {},
				tr_length: '',
				credits: {},
				lang: native_lang,
				short_lang: short_lang,
				kodik_api: "91cda3daa53978fdc025304879980c89",
				kodik_url: "https://kodikapi.com/",
				kodik_resp: {},
				kodik_types: 'cartoon-serial, documentary-serial, russian-serial, foreign-serial, anime-serial, multi-part-film'
			}
		},

		methods: {
			getVideoTrailers() {
				axios.get('https://api.themoviedb.org/3/tv/' + this.imdb_id + '/videos', {
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
				axios.get('https://api.themoviedb.org/3/tv/' + this.imdb_id, {
					params: {
						api_key: this.api_key,
						language: this.lang,
						append_to_response: 'videos,credits'
					},
				}).then(response => {
					this.video = response.data;
					this.trailers = response.data.videos;
					this.tr_length = this.trailers.results.length;
					this.credits = response.data.credits;
					this.getVideoPlayer();
				});
			},
			getVideoEnInfo(total) {
				axios.get('https://api.themoviedb.org/3/tv/' + this.imdb_id, {
					params: {
						api_key: this.api_key,
						language: 'en-US',
					},
				}).then(response => {
					this.video_en = response.data;
					if (total === 0) {
						this.getVideoPlayerTitle(this.video_en.name);
					}
				});
			},

			getVideoPlayer() {
				if (this.video.imdb_id) {
					axios.get(this.kodik_url + 'search', {
						params: {
							token: this.kodik_api,
							imdb_id: this.video.imdb_id,
							types: this.kodik_types
						},
					}).then(resp => {
						this.kodik_resp = resp.data.results;
						if (!this.video.overview) {
							this.getVideoEnInfo(resp.data.total);
						} else {
							if (resp.data.total === 0) {
								if (this.short_lang === "ru") {
									this.getVideoPlayerTitle(this.video.name);
								} else {
									this.getVideoPlayerTitle(this.video.original_name);
								}
							}
						}
					});
				} else {
					if (!this.video.overview) {
						this.getVideoEnInfo(0);
					} else {
						if (this.short_lang === "ru") {
							this.getVideoPlayerTitle(this.video.name);
						} else {
							this.getVideoEnInfo(0);
						}
					}
				}
			},

			getVideoPlayerTitle(title) {
				axios.get(this.kodik_url + 'search', {
					params: {
						title: title,
						strict: true,
						types: this.kodik_types,
						token: this.kodik_api
					},
				}).then(resp => {
					this.kodik_resp = resp.data.results;
				});
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
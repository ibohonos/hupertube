<template>
	<div class="row film-details" v-if="!loader">
		<div class="col-md-12">
			<div class="overlay">
				<img class="background-img" src="https://www.tpv.com/wp-content/uploads/2016/02/salestpv-video-header-poster.jpg" width="100%">
			</div>
			<div class="row film-desc">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							<img v-if="persone.profile_path" :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + persone.profile_path" width="100%">
							<img v-else src="http://oldquarteracousticcafe.com/wp-content/uploads/2018/07/Copy-of-Event-Flyer-TEmplate-Made-with-PosterMyWall-44.jpg" width="100%">
						</div>
						<div class="col-md-8">
							<h1 class="text-center">{{ persone.name }}</h1>
							<p class="desc" v-if="persone.biography">{{ persone.biography }}</p>
							<p class="desc" v-else>&nbsp;</p>
							<ul>
								<li>
									<h3>Дата народження:</h3>
									<span>{{ persone.birthday }}</span>
								</li>
								<li>
									<h3>Місце народження:</h3>
									<span>{{ persone.place_of_birth }}</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<h1 class="text-center">Фільми</h1>
		</div>

		<video-list v-for="video in videos.cast" :key="video.id" :video="video" :user_token="user_token"></video-list>

		<div class="col-md-12">
			<h1 class="text-center">Серіали</h1>
		</div>

		<serials-list v-for="video in serials.cast" :key="video.id" :video="video" :user_token="user_token"></serials-list>

		<a href="javascript:" id="return-to-top" @click="scrollToTop"><i class="fa fa-arrow-up"></i></a>
	</div>
	<div class="loader mx-auto" v-else></div>
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
			return  {
				api_key: 'e4649c026a8d8a3c93ed840286816339',
				videos: {},
				serials: {},
				loader: true,
				persone: {},
				lang: native_lang
			}
		},

		methods: {
			getPersone() {
				axios.get('https://api.themoviedb.org/3/person/' + this.imdb_id, {
					params: {
						api_key: this.api_key,
						append_to_response: 'movie_credits,tv_credits',
						language: this.lang
					},
				}).then(response => {
					this.persone = response.data;
					this.videos = response.data.movie_credits;
					this.serials = response.data.tv_credits;
					this.loader = false;
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
			this.getPersone();
			$(window).scroll(function() {
				if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
					$('#return-to-top').fadeIn(200);    // Fade in the arrow
				} else {
					$('#return-to-top').fadeOut(200);   // Else fade out the arrow
				}
			});
		}
	}
</script>

<style scoped>

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
</style>

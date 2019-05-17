<template>
	<div v-if="!loader">
		<div class="row">
			<div class="col-md-12">
				<nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-movies-tab" data-toggle="tab" href="#nav-movies" role="tab" aria-controls="nav-movies" aria-selected="true">Movies ({{ video_count }})</a>
						<a class="nav-item nav-link" id="nav-serials-tab" data-toggle="tab" href="#nav-serials" role="tab" aria-controls="nav-serials" aria-selected="false">Serials ({{ serial_count }})</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent" style="margin: 20px auto;">
					<div class="tab-pane fade show active" id="nav-movies" role="tabpanel" aria-labelledby="nav-movies-tab">
						<h2 class="text-center">Movies</h2>
						<div class="row">
							<video-list2 v-for="video in videos" :key="video.id" :imdb_id="video.imdb_id" :user_token="user_token"></video-list2>
							<div class="col-md-12 text-center" v-if="videos.length === 0"><h3>{{ $lang.videos.no_news }}</h3></div>
							<div class="col-md-12">
								<infinite-loading @infinite="infiniteHandlerFilms" spinner="waveDots" ref="infiniteLoading">
									<span slot="no-more">
										{{ $lang.videos.no_news }}
									</span>
								</infinite-loading>
							</div>
							<span slot="no-more" v-if="!videos">
								{{ $lang.videos.no_news }}
							</span>
						</div>
					</div>
					<div class="tab-pane fade" id="nav-serials" role="tabpanel" aria-labelledby="nav-serials-tab">
						<h2 class="text-center">Serials</h2>
						<div class="row">
							<serials-list2 v-for="serial in serials" :key="serial.id" :imdb_id="serial.imdb_id" :user_token="user_token"></serials-list2>
							<div class="col-md-12 text-center" v-if="serials.length === 0"><h3>{{ $lang.videos.no_news }}</h3></div>
							<div class="col-md-12">
								<infinite-loading @infinite="infiniteHandlerSerials" spinner="waveDots" ref="infiniteLoading">
									<span slot="no-more">
										{{ $lang.videos.no_news }}
									</span>
								</infinite-loading>
							</div>
							<span slot="no-more" v-if="!videos">
								{{ $lang.videos.no_news }}
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<a href="javascript:" id="return-to-top" @click="scrollToTop"><i class="fa fa-arrow-up"></i></a>
	</div>
	<div class="loader" v-else></div>
</template>

<script>
	import InfiniteLoading from 'vue-infinite-loading';

	export default {
		components: {
			InfiniteLoading,
		},

		props: {
			user_token: {
				type: String,
				required: true
			}
		},

		data() {
			return {
				loader: true,
				videos: [],
				video_count: 0,
				video_page: 1,
				serials: [],
				serial_count: 0,
				serial_page: 1
			}
		},

		methods: {
			isViewMethodFilms() {
				axios.get('/api/v2/all-view-later-films', {
					params: {
						api_token: this.user_token,
						page: this.video_page
					},
				}).then(resp => {
					this.video_count = resp.data.data.total;
					this.videos = this.videos.concat(resp.data.data.data);
					this.loader = false;
				});
			},

			isViewMethodSerials() {
				axios.get('/api/v2/all-view-later-serials', {
					params: {
						api_token: this.user_token,
						page: this.serial_page
					},
				}).then(resp => {
					this.serial_count = resp.data.data.total;
					this.serials = this.serials.concat(resp.data.data.data);
					this.loader = false;
				});
			},

			scrollVideos($state) {
				axios.get('/api/v2/all-view-later-films', {
					params: {
						api_token: this.user_token,
						page: this.video_page
					},
				}).then(resp => {
					if (resp.data.data.next_page_url) {
						this.videos = this.videos.concat(resp.data.data.data);
						$state.loaded();
					} else {
						this.videos = this.videos.concat(resp.data.data.data);
						$state.complete();
					}
				});
			},

			scrollSerials($state) {
				axios.get('/api/v2/all-view-later-serials', {
					params: {
						api_token: this.user_token,
						page: this.serial_page
					},
				}).then(resp => {
					if (resp.data.data.next_page_url) {
						this.serials = this.serials.concat(resp.data.data.data);
						$state.loaded();
					} else {
						this.serials = this.serials.concat(resp.data.data.data);
						$state.complete();
					}
				});
			},

			infiniteHandlerFilms($state) {
				this.video_page++;
				this.scrollVideos($state);
			},

			infiniteHandlerSerials($state) {
				this.serial_page++;
				this.scrollSerials($state);
			},

			scrollToTop() {
				$('body,html').animate({
					scrollTop : 0				// Scroll to top of body
				}, 500);
			}
		},

		mounted() {
			this.isViewMethodFilms();
			this.isViewMethodSerials();
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

	#return-to-top {
		position: fixed;
		bottom: 20px;
		right: 20px;
		background: rgb(0, 0, 0);
		background: rgba(0, 0, 0, 0.7);
		width: 50px;
		height: 50px;
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

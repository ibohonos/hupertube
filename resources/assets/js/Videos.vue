<template>
	<div class="row" v-if="!loader">
		<div class="col-md-12">
			<div class="form-group">
				<input type="text" class="form-control form-control-lg" v-model="query_term"
					   :placeholder="$lang.videos.film_name" @change="changeFilter">
			</div>
			<h3>{{ $lang.videos.quality }}:</h3>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" v-model="quality" name="exampleRadios" id="exampleRadios1" value="All" checked @change="changeFilter">
				<label class="form-check-label" for="exampleRadios1">
					{{ $lang.videos.quality_all }}
				</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" v-model="quality" name="exampleRadios" id="exampleRadios2" value="3D" @change="changeFilter">
				<label class="form-check-label" for="exampleRadios2">
					3D
				</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" v-model="quality" name="exampleRadios" id="exampleRadios3" value="720p" @change="changeFilter">
				<label class="form-check-label" for="exampleRadios3">
					720p
				</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" v-model="quality" name="exampleRadios" id="exampleRadios4" value="1080p" @change="changeFilter">
				<label class="form-check-label" for="exampleRadios4">
					1080p
				</label>
			</div>
			<div class="row">
				<div class="form-group col">
					<label for="sortBy">{{ $lang.videos.sort_by }}</label>
					<select class="form-control" id="sortBy" v-model="sort_by" @change="changeFilter">
						<option value="title">Title</option>
						<option value="year">Year</option>
						<option value="rating">Rating</option>
						<option value="peers">Peers</option>
						<option value="seeds">Seeds</option>
						<option value="download_count">Download count</option>
						<option value="like_count">Like count</option>
						<option value="date_added">Date added</option>
					</select>
				</div>
				<div class="form-group col">
					<label for="orderBy">{{ $lang.videos.type }}</label>
					<select class="form-control" id="orderBy" v-model="order_by" @change="changeFilter">
						<option value="asc">Asc</option>
						<option value="desc">Desc</option>
					</select>
				</div>
			</div>
			<div class="form-group" v-if="genres">
				<label for="genre">{{ $lang.videos.genre }}</label>
				<select class="form-control" id="genre" v-model="genre" @change="changeFilter">
					<option value="">Default</option>
					<option v-for="item in genres" :key="item.id" :value="item.name">{{ item.name }}</option>
				</select>
			</div>
		</div>
		<video-list v-for="video in videos" :key="video.id" :imdb_id="video.imdb_code" :rating="video.rating" :year="video.year" :user_token="user_token"></video-list>
		<div class="col-md-12">
			<infinite-loading @infinite="infiniteHandler" spinner="waveDots" ref="infiniteLoading">
				<span slot="no-more">
					{{ $lang.videos.no_news }}
				</span>
			</infinite-loading>
		</div>
		<span slot="no-more" v-if="!videos">
			{{ $lang.videos.no_news }}
		</span>
		<a href="javascript:" id="return-to-top" @click="scrollToTop"><i class="fa fa-arrow-up"></i></a>
	</div>
	<div class="loader mx-auto" v-else></div>
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
			return  {
				api_key: 'e4649c026a8d8a3c93ed840286816339',
				t_video: true,
				videos: {},
				loader: true,
				page: 1,
				limit: 12,
				sort_by: "download_count",
				order_by: 'desc',
				quality: 'All',
				minimum_rating: 0,
				query_term: "",
				genre: "",
				lang: native_lang,
				genres: {}
			}
		},

		watch: {
			query_term() {
				this.page = 1;
				this.debouncedGetAllVideos();
			},

			quality() {
				this.page = 1;
				this.debouncedGetAllVideos();
			},

			sort_by() {
				this.page = 1;
				this.debouncedGetAllVideos();
			},

			order_by() {
				this.page = 1;
				this.debouncedGetAllVideos();
			},

			genre() {
				this.page = 1;
				this.debouncedGetAllVideos();
			}
		},

		created() {
			this.debouncedGetAllVideos = _.debounce(this.getAllVideos, 500);
		},

		methods: {
			getAllVideos() {
				axios.get('https://yts.am/api/v2/list_movies.json', {
					params: {
						page: this.page,
						limit: this.limit,
						sort_by: this.sort_by,
						order_by: this.order_by,
						quality: this.quality,
						minimum_rating: this.minimum_rating,
						query_term: this.query_term,
						genre: this.genre
					},
				}).then(response => {
						this.videos = response.data.data.movies;
						this.loader = false;
					});
			},

			getAllGenres() {
				axios.get('https://api.themoviedb.org/3/genre/movie/list', {
					params: {
						api_key: this.api_key
					}
				}).then(resp => {
					this.genres = resp.data.genres;
				});
			},

			scrollVideos($state) {
				axios.get('https://yts.am/api/v2/list_movies.json', {
					params: {
						page: this.page,
						limit: this.limit,
						sort_by: this.sort_by,
						order_by: this.order_by,
						quality: this.quality,
						minimum_rating: this.minimum_rating,
						query_term: this.query_term,
						genre: this.genre
					},
				}).then(response => {
					if (response.data.data.movie_count > 0 && response.data.data.movies && response.data.data.movies.length > 0) {
						this.videos = this.videos.concat(response.data.data.movies);
						$state.loaded();
					} else {
						$state.complete();
					}
				});
			},

			infiniteHandler($state) {
				this.page++;
				this.scrollVideos($state);
			},

			changeFilter() {
				this.$nextTick(() => {
					this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
				});
			},

			testVideo(imdb_id) {
				axios.get('https://api.themoviedb.org/3/movie/' + imdb_id, {
					params: {
						api_key: this.api_key,
					},
				}).then(resp => {
					return true;
				}).catch(err => {
					return false;
				})
			},

			scrollToTop() {
				$('body,html').animate({
					scrollTop : 0				// Scroll to top of body
				}, 500);
			}
		},
		mounted() {
			this.$lang.setLang(currentLang);
			this.getAllVideos();
			this.getAllGenres();
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

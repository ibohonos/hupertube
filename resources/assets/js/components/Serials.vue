<template>
	<div class="row" v-if="!loader">
		<div class="col-md-12">
			<div class="form-group">
				<input type="text" class="form-control form-control-lg" v-model="query_term"
					   :placeholder="$lang.videos.film_name" @change="changeFilter">
			</div>
			<div class="row">
				<div class="form-group col">
					<label for="sortBy">{{ $lang.videos.sort_by }}</label>
					<select class="form-control" id="sortBy" v-model="sort_by" @change="changeFilter">
						<option value="year">Year</option>
						<option value="created_at">Created</option>
						<option value="updated_at">Updated</option>
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
			<!--<div class="form-group" v-if="genres">-->
				<!--<label for="genre">{{ $lang.videos.genre }}</label>-->
				<!--<select class="form-control" id="genre" v-model="genre" @change="changeFilter">-->
					<!--<option value="">Default</option>-->
					<!--<option v-for="item in genres" :key="item.id" :value="item.name">{{ item.name }}</option>-->
				<!--</select>-->
			<!--</div>-->
		</div>
		<serials-list v-for="video in videos" :key="video.id" :kodik="video" :imdb_id="video.imdb_id" :video_id="video.id.toString()" :user_token="user_token"></serials-list>
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
				limit: 12,
				sort_by: "updated_at",
				order_by: 'desc',
				query_term: "",
				genre: "",
				genres: {},
				kodik_api: "91cda3daa53978fdc025304879980c89",
				kodik_url: "https://kodikapi.com/",
				kodik_types: "documentary-serial,russian-serial,foreign-serial,multi-part-film,russian-documentary-serial,russian-cartoon-serial", //,anime-serial, cartoon-serial,
				kodik_next: ""
			}
		},

		watch: {
			query_term() {
				this.debouncedGetAllVideos();
			},

			sort_by() {
				this.debouncedGetAllVideos();
			},

			order_by() {
				this.debouncedGetAllVideos();
			},

			genre() {
				this.debouncedGetAllVideos();
			}
		},

		created() {
			this.debouncedGetAllVideos = _.debounce(this.getAllVideos, 500)
		},

		methods: {
			getAllVideos() {
				if (this.query_term === "") {
					axios.get(this.kodik_url + 'list', {
						params: {
							token: this.kodik_api,
							limit: this.limit,
							sort: this.sort_by,
							order: this.order_by,
							types: this.kodik_types
						},
					}).then(response => {
						this.videos = response.data.results;
						this.kodik_next = response.data.next_page;
						this.loader = false;
					});
				} else {
					axios.get(this.kodik_url + 'search', {
						params: {
							token: this.kodik_api,
							title: this.query_term,
							limit: this.limit,
							types: this.kodik_types
						},
					}).then(response => {
						this.videos = response.data.results;
						this.kodik_next = response.data.next_page;
						this.loader = false;
					});
				}
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
				if (this.kodik_next) {
					axios.get(this.kodik_next).then(response => {
						if (response.data.results) {
							this.videos = this.videos.concat(response.data.results);
							this.kodik_next = response.data.next_page;
							$state.loaded();
						} else {
							$state.complete();
						}
					});
				} else {
					$state.complete();
				}
			},

			infiniteHandler($state) {
				this.scrollVideos($state);
			},

			changeFilter() {
				this.$nextTick(() => {
					this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
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

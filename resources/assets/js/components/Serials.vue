<template>
	<div class="row" v-if="!loader">
		<div class="col-md-12">
			<div class="form-group">
				<input type="text" class="form-control form-control-lg" v-model="query_term"
					   :placeholder="$lang.videos.film_name" @change="changeFilter">
			</div>
			<div class="row">
				<div class="form-group col">
					<label for="year_from">Year from</label>
					<!--<datepicker v-model="year_from" @change="changeFilter"></datepicker>-->
					<input class="form-control" id="year_from" v-model="year_from" @change="changeFilter" placeholder="2010-10-12" >
				</div>
				<div class="form-group col">
					<label for="year_to">Year to</label>
					<input class="form-control" id="year_to" v-model="year_to" @change="changeFilter" >
				</div>
			</div>
			<div class="row">
				<div class="form-group col">
					<label for="sortBy">{{ $lang.videos.sort_by }}</label>
					<select class="form-control" id="sortBy" v-model="sort_by" @change="changeFilter">
						<option value="">Default</option>
						<option value="popularity">Popularity</option>
						<option value="vote_average">Vote average</option>
						<option value="first_air_date">Release date</option>
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
					<option v-for="item in genres" :key="item.id" :value="item.id">{{ item.name }}</option>
				</select>
			</div>
		</div>
		<serials-list v-for="video in videos" :key="video.id" :video="video" :user_token="user_token"></serials-list>
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
	// import V_Pikaday from 'vue-pikaday-directive';

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
				sort_by: "popularity",
				order_by: 'desc',
				quality: 'All',
				minimum_rating: 0,
				query_term: "",
				genre: "",
				lang: native_lang,
				genres: {},
				year_from: "",
				year_to: "",
				show: false
			}
		},

		watch: {
			query_term() {
				this.page = 1;
				if (this.query_term === "") {
					this.debouncedGetAllVideos();
				} else {
					this.debouncedGetSearchAllVideos();
				}
			},

			year_from() {
				this.page = 1;
				this.debouncedGetAllVideos();
			},

			year_to() {
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
			this.debouncedGetSearchAllVideos = _.debounce(this.getAllSearchVideos, 500);
		},

		methods: {
			getAllVideos() {
				axios.get('https://api.themoviedb.org/3/discover/tv', {
					params: {
						api_key: this.api_key,
						page: this.page,
						sort_by: this.sort_by + '.' + this.order_by,
						'primary_release_date.gte': this.year_from,
						'primary_release_date.lte': this.year_to,
						with_genres: this.genre,
						language: this.lang
					},
				}).then(response => {
					this.videos = response.data.results;
					this.loader = false;
				});
			},

			getAllSearchVideos() {
				axios.get('https://api.themoviedb.org/3/search/tv', {
					params: {
						api_key: this.api_key,
						page: this.page,
						query: this.query_term,
						language: this.lang
					},
				}).then(response => {
					this.videos = response.data.results;
					this.loader = false;
				});
			},

			getAllGenres() {
				axios.get('https://api.themoviedb.org/3/genre/tv/list', {
					params: {
						api_key: this.api_key,
						language: this.lang
					}
				}).then(resp => {
					this.genres = resp.data.genres;
				});
			},

			scrollVideos($state) {
				axios.get('https://api.themoviedb.org/3/discover/tv', {
					params: {
						api_key: this.api_key,
						page: this.page,
						sort_by: this.sort_by + '.' + this.order_by,
						'primary_release_date.gte': this.year_from,
						'primary_release_date.lte': this.year_to,
						with_genres: this.genre,
						language: this.lang
					},
				}).then(response => {
					if (response.data.results && response.data.results.length > 0) {
						this.videos = this.videos.concat(response.data.results);
						$state.loaded();
					} else {
						$state.complete();
					}
				});
			},

			scrollSearchVideos($state) {
				axios.get('https://api.themoviedb.org/3/search/tv', {
					params: {
						api_key: this.api_key,
						page: this.page,
						query: this.query_term,
						language: this.lang
					},
				}).then(response => {
					if (response.data.results && response.data.results.length > 0) {
						this.videos = this.videos.concat(response.data.results);
						$state.loaded();
					} else {
						$state.complete();
					}
				});
			},

			infiniteHandler($state) {
				this.page++;
				if (this.query_term === "") {
					this.scrollVideos($state);
				} else {
					this.scrollSearchVideos($state);
				}
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
			},

			initCreateDateSelectors() {
				let curDateFromSel = $("#year_from");
				let curDateToSel = $("#year_to");

				/**
				 * Объект дефолтных настроек селекторов дат
				 * @type {JSON}
				 */
				var defPickadateOptions = {
					'formatSubmit': "yyyy-mm-dd",
					'labelYearSelect': 'Вибір року',
					'labelMonthSelect': 'Вибір місяця',
					'selectMonths': true,
					'selectYears': true,
				};

				curDateFromSel.attr('data-value', $("input[name='from_submit']").val()).pickadate(defPickadateOptions);
				curDateToSel.attr('data-value', $("input[name='to_submit']").val()).pickadate(defPickadateOptions);
			}
		},

		mounted() {
			this.$lang.setLang(currentLang);
			this.year_to = new Date();
			this.year_to = this.year_to.getFullYear() + '-' + (this.year_to.getMonth() + 1) + '-' + this.year_to.getDate();
			// this.initCreateDateSelectors();
			this.getAllVideos();
			this.getAllGenres();
			$(window).scroll(function() {
				if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
					$('#return-to-top').fadeIn(200);    // Fade in the arrow
				} else {
					$('#return-to-top').fadeOut(200);   // Else fade out the arrow
				}
			});
		},

		// directives: {
		// 	'pikaday': V_Pikaday
		// }
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

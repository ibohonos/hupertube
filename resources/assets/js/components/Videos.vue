<template>
	<div class="row" v-if="!loader">
		<div class="col-md-4" v-for="video in videos" v-if="video">
			<video-list :imdb_id="video.imdb_code" :video_id="video.id" :rating="video.rating" :year="video.year"></video-list>
		</div>
		<div class="col-md-12">
			<infinite-loading @infinite="infiniteHandler" spinner="waveDots">
				<span slot="no-more">
					{{ $lang.videos.no_news }}
				</span>
			</infinite-loading>
		</div>
	</div>
	<div class="loader mx-auto" v-else></div>
</template>

<script>
	import InfiniteLoading from 'vue-infinite-loading';

	export default {
		components: {
			InfiniteLoading,
		},

		data() {
			return  {
				videos: {},
				loader: true,
				page: 1,
				limit: 12,
			}
		},

		methods: {
			getAllVideos() {
				axios.get('https://yts.am/api/v2/list_movies.json', {
					params: {
						page: this.page,
						limit: this.limit,
					},
				}).then(response => {
						this.videos = response.data.data.movies;
						this.loader = false;
					});
			},

			scrollVideos($state) {
				axios.get('https://yts.am/api/v2/list_movies.json', {
					params: {
						page: this.page,
						limit: this.limit,
					},
				}).then(response => {
					if (response.data.data.movies.length) {
						this.videos = this.videos.concat(response.data.data.movies);
						$state.loaded();
//						if (this.videos.length / 20 === 10) {
//							$state.complete();
//						}
					} else {
						$state.complete();
					}
				});
			},

			infiniteHandler($state) {
				this.page++;
				this.scrollVideos($state);
			}
		},
		mounted() {
			this.$lang.setLang(currentLang);
			this.getAllVideos();
		}
	}
</script>

<style scoped>
	.loader {
		border-top: 16px solid blue;
		border-right: 16px solid green;
		border-bottom: 16px solid red;
		border-left: 16px solid pink;
		border-radius: 50%;
		width: 150px;
		height: 150px;
		animation: spin 2s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>

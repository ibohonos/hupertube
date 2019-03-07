<template>
	<div class="col-md-4" v-if="!loader">
		<figure class="film-plate">
			<a :href="'/serial/' + video.id">
				<div class="overlay">
					<div class="additional-info">
						<p class="rating" v-if="video.vote_average">{{ video.vote_average }}/10</p>
						<p class="year" v-if="video.first_air_date">{{ video.first_air_date }}</p>
						<h2>{{ video.name }}</h2>
						<div class="film-icons-info" v-if="user_token !== 'Null'">
							<viewed video_type="serials" :imdb_id="'' + video.id" :user_token="user_token"></viewed>
							<view-later video_type="serials" :imdb_id="'' + video.id" :user_token="user_token"></view-later>
						</div>
					</div>
					<img v-if="video.poster_path" :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%">
					<img v-else src="http://oldquarteracousticcafe.com/wp-content/uploads/2018/07/Copy-of-Event-Flyer-TEmplate-Made-with-PosterMyWall-44.jpg" width="100%">
				</div>
			</a>
		</figure>
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
				api_key: 'e4649c026a8d8a3c93ed840286816339',
				loader: true,
				lang: native_lang,
			}
		},

		methods: {
			getVideoInfo() {
				axios.get('https://api.themoviedb.org/3/tv/' + this.imdb_id, {
					params: {
						api_key: this.api_key,
						language: this.lang
					},
				}).then(response => {
					this.video = response.data;
					this.loader = false;
				});
			},
		},

		mounted() {
			this.getVideoInfo();
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
</style>

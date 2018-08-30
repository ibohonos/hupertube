<template>
	<div class="col-md-4" v-if="is_visible">
		<figure class="film-plate" v-if="!loader">
			<a :href="'/video/' + imdb_id + '/' + video_id">
				<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%">
				<div class="info">
					<h2>{{ video.title }}</h2>
					<span class="genre" v-for="(genre, index) in video.genres" v-if="genre">
						{{ genre.name }}<span v-if="video.genres.length > 1 &&
						index != video.genres.length - 1">,</span>
					</span>
					<p class="year" v-if="year">{{ year }}</p>
					<span class="rating" v-if="rating">{{ rating }}/10</span>
				</div>
			</a>
		</figure>
		<div class="loader" v-else></div>
	</div>
</template>

<script>
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
			year: {
				type: Number,
				required: false
			},
			rating: {
				type: Number,
				required: false
			}
		},

		data() {
			return {
				video: {},
				api_key: 'e4649c026a8d8a3c93ed840286816339',
				loader: true,
				lang: native_lang,
				is_visible: true
			}
		},

		methods: {
			getVideoInfo() {
				axios.get('https://api.themoviedb.org/3/movie/' + this.imdb_id, {
					params: {
						api_key: this.api_key,
						language: this.lang,
					},
				}).then(response => {
						this.video = response.data;
						this.loader = false;
					}).catch(error => {
						this.is_visible = false;
				});
			}
		},

		mounted() {
			this.getVideoInfo();
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
		width: 100px;
		height: 100px;
		animation: spin 2s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>
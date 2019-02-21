<template>
	<div class="col-md-4" >
		<div v-if="is_visible">
			<figure class="film-plate" v-if="!loader">
				<a :href="'/serial/' + imdb_id">
					<div class="overlay">
						<div class="additional-info">
							<p class="rating" v-if="video.vote_average">{{ video.vote_average }}/10</p>
							<p class="year" v-if="video.first_air_date">{{ video.first_air_date }}</p>
							<p class="season" v-if="kodik_resp && kodik_resp[0] && kodik_resp[0].last_season && kodik_resp[0].last_episode">S: {{ kodik_resp[0].last_season }} E: {{ kodik_resp[0].last_episode }}</p>
							<h2>{{ video.name }}</h2>
							<div class="film-icons-info" v-if="user_token !== 'Null'">
								<viewed video_type="serials" :imdb_id="imdb_id" :user_token="user_token"></viewed>
								<view-later video_type="serials" :imdb_id="imdb_id" :user_token="user_token"></view-later>
							</div>
						</div>
						<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + video.poster_path" width="100%">
					</div>
				</a>
			</figure>
			<div class="loader" v-else></div>
		</div>

		<div v-else-if="kodik">
			<figure class="film-plate" v-if="!loader">
				<a :href="'/serial/' + kodik.title">
					<div class="overlay">
						<div class="additional-info">
							<p class="year" v-if="kodik.year">{{ kodik.year }}</p>
							<p class="season" v-if="kodik.last_season && kodik.last_episode">S: {{ kodik.last_season }} E: {{ kodik.last_episode }}</p>
							<h2>{{ kodik.title }}</h2>
							<div class="film-icons-info" v-if="user_token !== 'Null' && kodik">
								<viewed video_type="serials" :imdb_id="kodik.title" :user_token="user_token"></viewed>
								<view-later video_type="serials" :imdb_id="kodik.title" :user_token="user_token"></view-later>
							</div>
						</div>
						<img src="http://oldquarteracousticcafe.com/wp-content/uploads/2018/07/Copy-of-Event-Flyer-TEmplate-Made-with-PosterMyWall-44.jpg" width="100%">
					</div>
				</a>
			</figure>
			<div class="loader" v-else></div>
		</div>
		<div v-else-if="kodik_resp">
			<figure class="film-plate" v-if="!loader">
				<a :href="'/serial/' + kodik_resp.title">
					<div class="overlay">
						<div class="additional-info">
							<p class="year" v-if="kodik_resp.year">{{ kodik_resp.year }}</p>
							<p class="season" v-if="kodik_resp.last_season && kodik_resp.last_episode">S: {{ kodik_resp.last_season }} E: {{ kodik_resp.last_episode }}</p>
							<h2>{{ kodik_resp.title }}</h2>
							<div class="film-icons-info" v-if="user_token !== 'Null'">
								<viewed video_type="serials" :imdb_id="kodik_resp.title" :user_token="user_token"></viewed>
								<view-later video_type="serials" :imdb_id="kodik_resp.title" :user_token="user_token"></view-later>
							</div>
						</div>
						<img src="http://oldquarteracousticcafe.com/wp-content/uploads/2018/07/Copy-of-Event-Flyer-TEmplate-Made-with-PosterMyWall-44.jpg" width="100%">
					</div>
				</a>
			</figure>
			<div class="loader" v-else></div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			imdb_id: {
				required: false
			},
			user_token: {
			    type: String,
				required: true
			},
			kodik: {
				type: Object,
				required: false
			}
		},

		data() {
			return {
				video: {},
				api_key: 'e4649c026a8d8a3c93ed840286816339',
				loader: true,
				lang: native_lang,
				is_visible: true,
				rating: "",
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
						external_source: "imdb_id"
					},
				}).then(response => {
					if (response.data.tv_results.length > 0) {
						this.video = response.data.tv_results[0];
					} else this.is_visible = false;
					this.loader = false;
				}).catch(error => {
					console.error(error);
					this.is_visible = false;
					this.loader = false;
				});
			},

			getVideoPlayer() {
				if (this.imdb_id) {
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
							this.kodik_resp = resp.data.results[0];
						});
					}
				}
			},
		},

		mounted() {
			this.getVideoInfo();
			this.getVideoPlayer();
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
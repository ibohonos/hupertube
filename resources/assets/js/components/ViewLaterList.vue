<template>
	<div v-if="!loader">
		<div class="row">
			<serials-list2 v-for="serial in serials" :key="serial.id" :imdb_id="serial.imdb_id" :user_token="user_token"></serials-list2>
			<video-list v-for="video in videos" :key="video.id" :imdb_id="video.imdb_id" :user_token="user_token"></video-list>
		</div>
		<a href="javascript:" id="return-to-top" @click="scrollToTop"><i class="fa fa-arrow-up"></i></a>
	</div>
	<div class="loader" v-else></div>
</template>

<script>
	export default {
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
				serials: []
			}
		},

		methods: {
			isViewMethod() {
				axios.get('/api/v2/all-view-later', {
					params: {
						api_token: this.user_token
					},
				}).then(resp => {
					let self = this;

					resp.data.data.forEach(function (item) {
						if (item.video_type === "films") {
							self.videos.push(item);
						} else if (item.video_type === "serials") {
							self.serials.push(item);
						}
					});
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
			this.isViewMethod();
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

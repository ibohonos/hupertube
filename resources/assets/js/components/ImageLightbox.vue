<template>
	<!-- The Modal/Lightbox -->
	<div id="myModal" class="my-modal" v-if="images">
		<span class="my-close" @click="closeModal()">&times;</span>
		<div class="my-modal-content">

			<div class="mySlides" v-for="(image, index) in images" :key="index">
				<div class="numbertext">{{ index + 1 }} / {{ images.length }}</div>
				<img :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + image.file_path" style="width:100%">
			</div>

			<!-- Next/previous controls -->
			<a class="my-prev" @click="plusSlides(-1)">&#10094;</a>
			<a class="my-next" @click="plusSlides(1)">&#10095;</a>


			<!-- Thumbnail image controls -->
<!--			<div class="row">-->
<!--				<div class="col-md-2" v-for="(image, index) in images" :key="index">-->
<!--					<img class="demo" :src="'https://image.tmdb.org/t/p/w600_and_h900_bestv2' + image.file_path" @click="currentSlide(index + 1)" style="width: 100%;">-->
<!--				</div>-->
<!--			</div>-->
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			images: {
				required: true,
				type: Array
			}
		},

		data() {
			return {
				display: "none",
				slideIndex: 1
			}
		},

		methods: {
			openModal() {
				document.getElementById('myModal').style.display = "block";
			},

			closeModal() {
				document.getElementById('myModal').style.display = "none";
			},

			plusSlides(n) {
				this.showSlides(this.slideIndex += n);
			},

			currentSlide(n) {
				this.slideIndex = n;
				this.showSlides(n);
			},

			showSlides(n) {
				let i;
				let slides = document.getElementsByClassName("mySlides");
				let dots = document.getElementsByClassName("demo");

				if (n > slides.length) {this.slideIndex = 1}

				if (n < 1) {this.slideIndex = slides.length}

				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";
				}

				for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" active", "");
				}

				slides[this.slideIndex-1].style.display = "block";
				dots[this.slideIndex-1].className += " active";
			}
		},

		mounted() {
			this.$root.$on('openModal', () => {
				this.openModal()
			});

			this.$root.$on('currentSlide', (res) => {
				this.currentSlide(res)
			});
		},

		created() {
			this.showSlides(this.slideIndex);
		}
	}
</script>

<style scoped>
	/* The Modal (background) */
	.my-modal {
		display: none;
		position: fixed;
		z-index: 1;
		padding-top: 100px;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		/*overflow: auto;*/
		background-color: rgba(0, 0, 0, 0.8);
	}

	/* Modal Content */
	.my-modal-content {
		position: relative;
		/*background-color: #fefefe;*/
		margin: auto;
		padding: 0;
		width: 50%;
		max-width: 1200px;
	}

	/* The Close Button */
	.my-close {
		color: white;
		position: absolute;
		top: 10px;
		right: 25px;
		font-size: 35px;
		font-weight: bold;
	}

	.my-close:hover,
	.my-close:focus {
		color: #999;
		text-decoration: none;
		cursor: pointer;
	}

	/* Hide the slides by default */
	.mySlides {
		display: none;
		width: 50%;
		margin: 0 auto;
	}

	/* Next & previous buttons */
	.my-prev,
	.my-next {
		cursor: pointer;
		position: absolute;
		top: 50%;
		width: auto;
		padding: 16px;
		margin-top: -50px;
		color: white !important;
		font-weight: bold;
		font-size: 20px;
		transition: 0.6s ease;
		border-radius: 0 3px 3px 0;
		user-select: none;
		-webkit-user-select: none;
	}

	/* Position the "next button" to the right */
	.my-next {
		right: 0;
		border-radius: 3px 0 0 3px;
	}

	/* On hover, add a black background color with a little bit see-through */
	.my-prev:hover,
	.my-next:hover {
		background-color: rgba(0, 0, 0, 0.8);
	}

	/* Number text (1/3 etc) */
	.numbertext {
		color: #f2f2f2;
		font-size: 12px;
		padding: 8px 12px;
		position: absolute;
		top: 0;
		background: rgba(0, 0, 0, 0.7);
	}

	/* Caption text */
	.caption-container {
		text-align: center;
		background-color: black;
		padding: 2px 16px;
		color: white;
	}

	img.demo {
		opacity: 0.6;
	}

	.active,
	.demo:hover {
		opacity: 1;
	}

</style>
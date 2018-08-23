<template>
	<div class="text-center">
		<img class="avatar" v-if="imgDataUrl" :src="imgDataUrl" v-show="true" style="display: none;">
		<a class="btn btn-success" @click="toggleShow">Upload</a>
		<my-upload url="/avatar/save"
				   @crop-success="cropSuccess"
				   :no-circle="true"
				   field="avatar"
				   ki="0"
				   lang-type="ua"
				   v-model="show"
				   :headers="headers"
				   :params="params"></my-upload>
	</div>
</template>

<script>
	import myUpload from 'vue-laravel-image-crop-upload';

	export default {
		components: {
			'my-upload': myUpload
		},

		props: {
			img: {
				type: String,
				required: true
			},
		},
		data() {
			return {
				show: false,
				params: {},
				headers: {
					smail: '*_~'
				},
				imgDataUrl: this.img, // the datebase64 url of created image
			}
		},
		methods: {
			toggleShow() {
				this.show = !this.show;
			},

			cropSuccess(imgDataUrl, field){
				this.imgDataUrl = imgDataUrl;
			},
		}
	}
</script>
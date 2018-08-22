<template>
	<div class="text-center">


		<img class="avatar" v-if="imgDataUrl" :src="imgDataUrl" v-show="true" style="display: none;">
		<a class="btn" @click="toggleShow">аватар</a>
		<my-upload url="/profile/avatar/view/"
				   @crop-success="cropSuccess"
				   @crop-upload-success="cropUploadSuccess"
				   @crop-upload-fail="cropUploadFail"
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
	import myUpload from 'vue-image-crop-upload';

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
				imgDataUrl: this.img // the datebase64 url of created image
			}
		},
		methods: {
			toggleShow() {
				this.show = !this.show;
			},

			saveImage(imgDataUrl) {
				axios.post('/profile/avatar/save/', {
					img: imgDataUrl
				})
					.then(resp => {
						console.log('resp');
						console.log(resp.config.data);
					});
			},

			cropSuccess(imgDataUrl, field){
				console.log('-------- crop success --------');
				this.imgDataUrl = imgDataUrl;
				this.saveImage(imgDataUrl);
			},

			cropUploadSuccess(jsonData, field){
				console.log('-------- upload success --------');
				console.log(jsonData);
				console.log('field: ' + field);
			},

			cropUploadFail(status, field){
				console.log('-------- upload fail --------');
				console.log(status);
				console.log('field: ' + field);
			}
		}
	}
</script>
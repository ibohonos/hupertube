<template>
	<div class="user-avatar">
		<img class="avatar" v-if="imgDataUrl" :src="imgDataUrl" v-show="true" style="display: none;">
		<a class="btn" @click="toggleShow"><i class="fab fa-upload"></i></a>
		<my-upload url="/avatar/save"
					@crop-success="cropSuccess"
					:no-circle="true"
					field="avatar"
					ki="0"
					:lang-type="c_lang"
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
				c_lang: currentLang,
			}
		},

		methods: {
			toggleShow() {
				this.show = !this.show;
			},

			cropSuccess(imgDataUrl, field){
				this.imgDataUrl = imgDataUrl;
			},
		},

		created() {
			if (this.c_lang === 'uk') {
				this.c_lang = 'ua'
			}
		}
	}
</script>
<template>
	<div class="row">
		<div class="col-md-12" v-for="video in videos.data">
			<a :href="'/video/' + video.id">{{ video.title }}</a>
			<p>{{ video.description }}</p>
			<p>{{ video.created_at }}</p>
		</div>
	</div>
</template>

<script>
	export default {
		data: function() {
			return  {
				videos: {}
			}
		},

		mounted() {
			axios.get('/api/v1/videos')
				.then(response => {
					this.videos = response.data;
				});
		}
	}
</script>

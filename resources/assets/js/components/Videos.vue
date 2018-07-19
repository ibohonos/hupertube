<template>
	<div>
		{{ videos.data }}
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

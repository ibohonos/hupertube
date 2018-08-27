<template>
	<div class="row">
		<div class="col-md-12">
			<!--<form method="post" action="/comment/save">-->
				<div class="form-group">
					<label for="comment">{{ $lang.comments.enter_comment }}:</label>
					<textarea class="form-control" id="comment" name="comment" rows="3" v-model="comment"></textarea>
				</div>
				<button class="btn btn-primary" type="submit" @click="sendComment">{{ $lang.comments.add_comment }}</button>
			<!--</form>-->
		</div>
		<div class="col-md-12" v-for="item in comments" v-if="item">
			<user-info :user_id="item.user_id"></user-info>
			{{ item.comment }}
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			imdb_id: {
				type: String,
				required: true
			}
		},

		data() {
			return {
				comment: '',
				comments: {}
			}
		},

		methods: {
			sendComment() {
				let formData = new FormData();

				if (this.comment) {
					formData.append('comment', this.comment);
					formData.append('imdb_id', this.imdb_id);

					axios.post('/comment/save', formData)
						.then(resp => {
							this.comment = '';
//							this.comments.$emit(resp.data);
						});
				}
			},

			getComments() {
				axios.get('/api/v1/comments/' + this.imdb_id)
					.then(resp => {
						this.comments = resp.data.data.comments;
					});
			}
		},

		mounted() {
			this.getComments();
		},
	}
</script>
<template>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="comment">{{ $lang.comments.enter_comment }}:</label>
				<textarea class="form-control" id="comment" name="comment" rows="3" v-model="comment"></textarea>
			</div>
			<button class="btn btn-primary" type="submit" @click="sendComment">{{ $lang.comments.add_comment }}</button>
		</div>
		<div class="col-md-12" v-for="item in comments" v-if="item">
			<div class="row">
				<div class="col-md-2">
					<user-info :user_id="item.user_id" :user_token="user_token"></user-info>
				</div>
				<div class="col-md-10">
					<p>{{ item.comment }}</p>
				</div>
			</div>
		</div>
		<div v-if="comments.length === 0">
			<p>No comments</p>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			imdb_id: {
				type: String,
				required: true
			},

			user_token: {
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
					formData.append('api_token', this.user_token);

					axios.post('/api/v2/comment/save', formData)
						.then(resp => {
							let new_array = [];

							this.comment = '';
							new_array = new_array.concat(resp.data.data.comment);
							this.comments = new_array.concat(this.comments);
						});
				}
			},

			getComments() {
				axios.get('/api/v2/comments/' + this.imdb_id, {
					params: {
						api_token: this.user_token
					},
				}).then(resp => {
					this.comments = resp.data.data.comments;
				});
			}
		},

		mounted() {
			this.getComments();
		},
	}
</script>
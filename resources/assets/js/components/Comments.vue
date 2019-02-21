<template>
	<div class="row">
		<div class="col-md-12 comment-container" v-if="user_token != 'Null'">
			<div class="form-group">
				<label for="comment">{{ $lang.comments.enter_comment }}:</label>
				<span class="input-group-addon"
					  v-text="(max - comment.length) + ' ' + $lang.comments.symbols"></span>
				<textarea class="form-control" id="comment" name="comment" rows="3" v-on:keyup.13="sendComment"
						  :maxlength="max" v-model="comment"></textarea>
			</div>
			<button class="btn btn-primary" type="submit" @click="sendComment">{{ $lang.comments.add_comment }}</button>
		</div>
		<div class="col-md-12 comment-container" v-for="item in comments" v-if="item">
			<div class="row">
				<div class="col-md-2">
					<a :href="'/user/' + item.user.id" v-if="item.user">
						<img :src="item.user.avatar" class="avatar-comment" />
						<p class="text-center">{{ item.user.first_name }} {{ item.user.last_name }}</p>
					</a>
				</div>
				<div class="col-md-10">
					<div class="comment-item">
						<p>{{ item.comment }}</p>
						<span>{{ item.created_at }}</span>
					</div>
				</div>
			</div>
		</div>
		<div v-else="comments.length === 0">
			<p>{{ $lang.comments.no_comments }}</p>
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
			},
		},

		data() {
			return {
                max: 1665,
				comment: '',
				comments: {},
				user: {}
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
						    console.log(resp.data.data); //comment i added
							let new_array = [];
							this.comment = '';
							new_array = new_array.concat(resp.data.data.comment);
							this.comments = new_array.concat(this.comments);
						});
				}
			},

			getComments() {
				axios.get('/api/v1/comments/' + this.imdb_id).then(resp => {
					this.comments = resp.data.data.comments;
				});
			},

            getCommentUser(user_id) {
                axios.get('/api/v2/comment/user/' + user_id, {
                    params: {
                        api_token: this.user_token
                    },
                })
                    .then(resp => {
                        this.user = resp.data.data.user;
                    });
            }
		},

		mounted() {
			this.getComments();
		},
	}
</script>
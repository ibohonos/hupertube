<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
	protected $fillable = ['user_id', 'comment'];

	public function user()
	{
		return $this->hasOne(User::class);
	}

	public function getCommentsByImdbId($imdb_id)
	{
		return $this->imdbId($imdb_id)->get();
	}

	public function scopeImdbId($query, $imdb_id)
	{
		$query->where(['imdb_id' => $imdb_id])->latest();
	}
}

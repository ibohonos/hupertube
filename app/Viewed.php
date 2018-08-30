<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewed extends Model
{
	protected $fillable = [
		'user_id',
		'video_id',
		'imdb_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function isViewed($imdb_id, $video_id, $user_id)
	{
		$isViewed = $this->viewed($imdb_id, $video_id, $user_id)->first();

		if ($isViewed) :
			return true;
		endif;

		return false;
	}

	public function findByIds($imdb_id, $video_id, $user_id)
	{
		return $this->viewed($imdb_id, $video_id, $user_id)->first();
	}

	public function scopeViewed($query, $imdb_id, $video_id, $user_id)
	{
		$query->where(['imdb_id' => $imdb_id, 'video_id' => $video_id, 'user_id' => $user_id]);
	}
}

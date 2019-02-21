<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewLater extends Model
{
	protected $fillable = [
		'user_id',
		'video_type',
		'imdb_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function isViewLater($imdb_id, $video_type, $user_id)
	{
		$isViewLater = $this->viewLater($imdb_id, $video_type, $user_id)->first();

		if ($isViewLater) :
			return true;
		endif;

		return false;
	}

	public function allViewLater($user_id)
	{
		return $this->allView($user_id)->get();
	}

	public function findByIds($imdb_id, $video_type, $user_id)
	{
		return $this->viewLater($imdb_id, $video_type, $user_id)->first();
	}

	public function scopeViewLater($query, $imdb_id, $video_type, $user_id)
	{
		$query->where(['imdb_id' => $imdb_id, 'video_type' => $video_type, 'user_id' => $user_id]);
	}

	public function scopeAllView($query, $user_id)
	{
		$query->where(['user_id' => $user_id])->latest();
	}
}

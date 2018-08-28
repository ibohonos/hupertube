<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewLater extends Model
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
}

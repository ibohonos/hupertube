<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
	protected $fillable = [
		'imdb_id', 'video', 'downloaded'
	];

	/**
	 * Video belong user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

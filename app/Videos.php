<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
	protected $fillable = [
		'title', 'description', 'image', 'video', 'category_id', 'user_id'
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

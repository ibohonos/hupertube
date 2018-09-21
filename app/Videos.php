<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
	protected $fillable = [
		'imdb_id', 'video', 'downloaded', 'quality', 'updated_at'
	];
}

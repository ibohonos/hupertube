<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
	protected $fillable = [
		'title', 'description', 'image', 'video', 'category_id'
	];
}

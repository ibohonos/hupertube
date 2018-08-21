<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'first_name', 'last_name', 'email', 'password', 'api_token', 'github_token', 'facebook_token', 'linkedin_token', 'google_token', '42_token', 'avatar'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * User has many videos
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function videos()
	{
		return $this->hasMany(Videos::class);
	}

	public static function getUserByEmail($email)
	{
		return self::email($email)->first();
	}

	public function activatedUser($id)
	{
		return $this->id($id)->first();
	}

	public function scopeId($query, $id)
	{
		$query->where(['id' => $id]);
	}

	public static function scopeEmail($query, $email)
	{
		$query->where(['email' => $email]);
	}
}

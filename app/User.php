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
		'name', 'first_name', 'last_name', 'email', 'password', 'api_token'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

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

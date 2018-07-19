<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterUser extends Mailable
{
	use Queueable, SerializesModels;

	protected $user;
	protected $url;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
		$this->url = route('user.activate', [
			'id' => $user->id,
			'token' => $user->api_token
		]);
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->markdown('emails.register.register')->with([
			'user' => $this->user,
			'url' => $this->url
		]);
	}
}

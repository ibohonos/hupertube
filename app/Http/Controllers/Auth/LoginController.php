<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	/**
	 * Redirect the user to the social authentication page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function redirectToProvider($social)
	{
		return Socialite::driver($social)->redirect();
	}

	/**
	 * Obtain the user information from social.
	 *
	 * @param $social
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function handleProviderCallback($social)
	{
		$userSocial = Socialite::driver($social)->user(); // Fetch authenticated user
		$user = User::where(['email' => $userSocial->getEmail()])->first();
		if ($user) :
			Auth::login($user, true);
			return redirect('/');
		endif;
		return view('auth.register',['name' => $userSocial->getName(), 'email' => $userSocial->getEmail(), 'token' => $userSocial->token, 'social' => $social]);
	}

}

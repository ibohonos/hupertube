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
	 * Show the application's login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showLoginForm()
	{
		if (Auth::guest()) :
			return view('auth.login');
		else :
			return redirect($this->redirectTo);
		endif;
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
		if (Auth::user()) :
			$userSocial = Socialite::driver($social)->user();
			User::where(['email' => Auth::user()->email])->update([$social . '_id' => $userSocial->getId()]);
			return redirect('/');
		else :
			$userSocial = Socialite::driver($social)->user();
			$user = User::where([$social . '_id' => $userSocial->getId()])->first();
			if ($user) :
				if (!$user->active) :
					return redirect(route('user.activate'));
				endif;
				Auth::login($user, true);
				return redirect('/');
			endif;
			$user = User::where(['email' => $userSocial->getEmail()])->first();
			if ($user) :
				User::where(['email' => $userSocial->getEmail()])->update([$social . '_id' => $userSocial->getId()]);
				if (!$user->active) :
					return redirect(route('user.activate'));
				endif;
				Auth::login($user, true);
				return redirect('/');
			endif;
			$res = explode(' ', $userSocial->getName());
			if (!isset($res[1]))
				$res[1] = null;
			return view('auth.register',['name' => $userSocial->getNickname(), 'first_name' => $res[0], 'last_name' => $res[1], 'email' => $userSocial->getEmail(), 'social_id' => $userSocial->getId(), 'social' => $social, 'avatar' => $userSocial->getAvatar()]);
		endif;
	}

}

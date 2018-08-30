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
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function login(Request $request)
	{
		$this->validateLogin($request);

		$user = User::getUserByEmail($request->email);

		if (!$user->active) {
			return redirect(route('activate.message'));
		}

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		if ($this->attemptLogin($request)) {
			return $this->sendLoginResponse($request);
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		$this->guard()->logout();

		$request->session()->invalidate();

		return $this->loggedOut($request) ?: redirect(route('index'));
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
			$user = User::where([$social . '_id' => $userSocial->getId()])->first();

			if (!$user) :
				User::where(['email' => Auth::user()->email])->update([$social . '_id' => $userSocial->getId()]);

				return redirect()->back()->with('status', __("Social connected"));
			endif;

			return redirect()->back()->with('status', __("User isset with this social"));
		else :
			$userSocial = Socialite::driver($social)->user();
			$user = User::where([$social . '_id' => $userSocial->getId()])->first();

			if ($user) :
				if (!$user->active) :
					return redirect(route('activate.message'));
				endif;

				Auth::login($user, true);

				return redirect()->back();
			endif;

			$user = User::where(['email' => $userSocial->getEmail()])->first();

			if ($user) :
				User::where(['email' => $userSocial->getEmail()])->update([$social . '_id' => $userSocial->getId()]);

				if (!$user->active) :
					return redirect(route('activate.message'));
				endif;

				Auth::login($user, true);

				return redirect()->back();
			endif;

			$res = explode(' ', $userSocial->getName());

			if (!isset($res[1])) :
				$res[1] = null;
			endif;

			return view('auth.register',['name' => $userSocial->getNickname(), 'first_name' => $res[0], 'last_name' => $res[1], 'email' => $userSocial->getEmail(), 'social_id' => $userSocial->getId(), 'social' => $social, 'avatar' => $userSocial->getAvatar()]);
		endif;
	}

}

<?php

namespace App\Http\Controllers;

use App\Mail\RegisterUser;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
	private $data = [];

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
//		if (Auth::user()) :
			return view('videos.index');
//		else :
//			return view('home');
//		endif;
	}

	public function serials()
	{
		return view('serials.index');
	}

	/**
	 * Activate user by token.
	 *
	 * @param $id
	 * @param $token
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function activateUser($id, $token)
	{
		$user = User::findOrFail($id);

		if ($user->api_token === $token)
		{
			$user->active = 1;
			$user->save();

			Session::forget('tmp_user_email');
		}
		return redirect(url('/login'));
	}

	/**
	 * Resend Email
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function reSendMail()
	{
		$email = Session::get('tmp_user_email');
		if ($email) :
			$user = User::getUserByEmail($email);

			Mail::to($email)->send(new RegisterUser($user));
			return redirect()->back();
		endif;
	}

	/**
	 * View message for activate account.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function activateView()
	{
		if (Auth::guest()) :
			return view('auth.activate');
		else :
			return redirect('/');
		endif;
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
//		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('home');
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
		}
		return redirect(url('/login'));
	}

	/**
	 * View message for activate account.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function activateView()
	{
		return view('auth.activate');
	}
}

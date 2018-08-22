<?php

namespace App\Http\Controllers;

use App\Mail\RegisterUser;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class ProfileController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
//		dd(storage_path('app/public/avatars/'));
		return view('user.index');
	}

	public function edit()
	{
		return view('user.edit');
	}

	public function unlink($social)
	{
		$user = Auth::user();

		$user[$social . '_id'] = null;
		$user->save();

		return redirect()->back();
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|string|max:255',
			'first_name' => 'required|string|max:255',
			'last_name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users,id,' . Auth::id()
		]);
	}

	public function save(Request $request)
	{
		$this->validator($request->all())->validate();

		$user = Auth::user();

		if (
			$user->name !== $request->name ||
			$user->first_name !== $request->first_name ||
			$user->last_name !== $request->last_name ||
			$request->password ||
			$user->email !== $request->email
		) :
			if ($user->name !== $request->name) :
				$user->name = $request->name;
			endif;
			if ($user->first_name !== $request->first_name) :
				$user->first_name = $request->first_name;
			endif;
			if ($user->last_name !== $request->last_name) :
				$user->last_name = $request->last_name;
			endif;
			if ($request->password) :
				$request->validate([
					'password' => 'required|string|min:6|confirmed'
				]);
				if ($user->password !== Hash::make($request->password)) :
					$user->password = Hash::make($request->password);
				endif;
			endif;
			if ($user->email !== $request->email) :
				$user->email = $request->email;
				$user->active = 0;

				Mail::to($user->email)->send(new RegisterUser($user));
				Auth::logout();

				return redirect('/activate');
			endif;
			$user->save();
		endif;

		Auth::login($user);

		return redirect()->back();
	}

	public function viewAvatar(Request $request)
	{
		return $request;
	}

	public function saveAvatar(Request $request)
	{
		dd($request);
//		$res = json_decode($request);
//		return $res['config']['data']['img'];
	}

}

<?php

namespace App\Http\Controllers;

use App\Mail\RegisterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;

class ProfileController extends Controller
{
	private $data = [];

	/**
	 * Create object
	 *
	 * ProfileController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * View user dashboard
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view('user.index');
	}

	/**
	 * View edit form
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit()
	{
		return view('user.edit');
	}

	public function userProfile($id)
	{
		$user = new User;

		$this->data['user'] = $user->getUserById($id);

		return view('user.profile', $this->data);
	}

	/**
	 * Delete social link
	 *
	 * @param $social
	 * @return \Illuminate\Http\RedirectResponse
	 */
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

	/**
	 * Update user info
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function save(Request $request)
	{
		$this->validator($request->all())->validate();

		$user = Auth::user();

		if (
			$user->name !== $request->name ||
			$user->first_name !== $request->first_name ||
			$user->last_name !== $request->last_name ||
			$user->email !== $request->email ||
			$request->password
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
				$user->save();

				Mail::to($user->email)->send(new RegisterUser($user));
				Auth::logout();

				return redirect(route('activate.message'));
			endif;
			$user->save();
		endif;

		return redirect()->back();
	}

	/**
	 * Save cropped avatar
	 *
	 * @param Request $request
	 * @return string
	 */
	public function saveAvatar(Request $request)
	{
		$avatar = $request->file('avatar');
		$path = storage_path('app/public/avatars/');
		$name = time() . '-' . Auth::user()->first_name . '-' . Auth::user()->last_name . '.' . $avatar->extension();
		$user = Auth::user();

		$avatar->move($path, $name);
		$user->avatar = '/storage/avatars/' . $name;
		$user->save();

		return $name;
	}

}

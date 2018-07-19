<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if ($request->getPathInfo() == '/login' && $request->getMethod() == "POST") {
			$email = $request->request->get('email');
			if (User::getUserByEmail($email) && User::getUserByEmail($email)->active == 0) {
				Session::put('not_activate', 'Ваш аккаунт не активен!');

				return redirect('/login');
			}
		}
		if (Auth::guard($guard)->check()) {
			return redirect('/');
		}

		return $next($request);
	}
}

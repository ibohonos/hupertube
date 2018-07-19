<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [
	'uses' => 'HomeController@index',
	'as' => 'index'
]);
Route::get('/home', [
	'uses' => 'HomeController@index',
	'as' => 'home'
]);

Route::get('/mailable', function () {
	$user = App\User::find(1);

	return new App\Mail\RegisterUser($user);
});

Route::get('/user/activate/{id}/{token}', [
	'uses' => 'HomeController@activateUser',
	'as' => 'user.activate'
]);

Route::get('/activate', 'HomeController@activateView');

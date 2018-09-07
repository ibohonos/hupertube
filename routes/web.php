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
Route::group([
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function () {

	Auth::routes();

	Route::get('/login/{social}', 'Auth\LoginController@redirectToProvider')->where('social', 'facebook|linkedin|google|github|intra')->name('social');
	Route::get('/login/{social}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'facebook|linkedin|google|github|intra')->name('social.callback');

	Route::get('/', [
		'uses' => 'HomeController@index',
		'as' => 'index'
	]);

	Route::get('/home', [
		'uses' => 'HomeController@index',
		'as' => 'home'
	]);

	Route::get('/user/activate/{id}/{token}', [
		'uses' => 'HomeController@activateUser',
		'as' => 'user.activate'
	]);

	Route::get('/activate', [
		'uses' => 'HomeController@activateView',
		'as' => 'activate.message'
	]);

	Route::get('/email/resend', [
		'uses' => 'HomeController@reSendMail',
		'as' => 'mail.resend'
	]);

	Route::middleware('auth')->group(function () {
		Route::get('/user/{id}', [
			'uses' => 'ProfileController@userProfile',
			'as' => 'user.profile'
		]);

		Route::get('/profile', [
			'uses' => 'ProfileController@index',
			'as' => 'profile'
		]);

		Route::get('/profile/edit', [
			'uses' => 'ProfileController@edit',
			'as' => 'profile.edit'
		]);

		Route::get('/videos', [
			'uses' => 'VideosController@index',
			'as' => 'videos.index'
		]);

		Route::get('/videos/add', [
			'uses' => 'VideosController@add',
			'as' => 'videos.add'
		]);

		Route::post('/videos/store', [
			'uses' => 'VideosController@store',
			'as' => 'videos.store'
		]);

		Route::get('/video/{id}/{video_id}', [
			'uses' => 'VideosController@show',
			'as' => 'videos.show'
		]);

		Route::get('/play/videos/{file}', [
			'uses' => 'VideosController@fileShow'
		]);

		Route::get('/profile/edit/unlink/{social}', [
			'uses' => 'ProfileController@unlink',
			'as' => 'unlink'
		]);

		Route::post('/profile/edit/save/', [
			'uses' => 'ProfileController@save',
			'as' => 'edit.save'
		]);

		Route::post('/avatar/save/', [
			'uses' => 'ProfileController@saveAvatar',
			'as' => 'avatar.save'
		]);

		Route::get('/view-later', [
			'uses' => 'ProfileController@viewLater',
			'as' => 'view.later'
		]);
	});
});


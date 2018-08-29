<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->namespace('API')->group(function () {
	Route::get('/videos', [
		'uses' => 'VideosController@index',
		'as' => 'allVideos'
	]);

	Route::get('/comments/{imdb_id}', [
		'uses' => 'VideosController@allComments',
		'as' => 'comments.all'
	]);

	Route::get('/comment/user/{id}', [
		'uses' => 'VideosController@getCommentUser',
		'as' => 'comments.all'
	]);
});

Route::prefix('v2')->middleware('auth:api')->namespace('API')->group(function () {
	Route::get('/user', function (Request $request) {
		return $request->user();
	})->name('user');

	Route::get('/is-viewed', [
		'uses' => 'UserController@isViewed'
	]);

	Route::post('/viewed', [
		'uses' => 'UserController@viewed'
	]);

	Route::get('/is-view-later', [
		'uses' => 'UserController@isViewLater'
	]);

	Route::post('/view-later', [
		'uses' => 'UserController@viewLater'
	]);

	Route::get('/all-view-later', 'UserController@allViewLater');
});

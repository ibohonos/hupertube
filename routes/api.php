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

Route::prefix('v2')->middleware('auth:api')->namespace('API')->group(function () {
	Route::get('/user', function (Request $request) {
		return $request->user();
	})->name('user');

	Route::get('/comments/{imdb_id}', [
		'uses' => 'VideosController@allComments',
		'as' => 'comments.all'
	]);

	Route::get('/comment/user/{id}', [
		'uses' => 'VideosController@getCommentUser',
		'as' => 'comments.all'
	]);

	Route::post('/comment/save', [
		'uses' => 'VideosController@saveComment',
		'as' => 'comment.save'
	]);

	Route::get('/is-viewed', 'UserController@isViewed');

	Route::post('/viewed', 'UserController@viewed');

	Route::get('/is-view-later', 'UserController@isViewLater');

	Route::post('/view-later', 'UserController@viewLater');

	Route::get('/all-view-later', 'UserController@allViewLater');

	Route::post('/insert-to-db', 'VideosController@insertToDB');
});

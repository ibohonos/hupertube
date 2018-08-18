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
});

Route::prefix('v2')->middleware('auth:api')->namespace('API')->group(function () {
	Route::get('/user', function (Request $request) {
		return $request->user();
	})->name('user');
});

<?php

namespace App\Http\Controllers\API;

use App\AllMovieIds;
use App\Comments;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideosController extends APIController
{
	private $data = [];

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$videos = AllMovieIds::paginate(20);
//		$videos = Storage::disk('local')->get('public/db/title.basics.tsv');
//		dd($videos);

		return $this->sendResponse($videos, "OK");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	public function allComments($imdb_id)
	{
		$comments = new Comments;

		$this->data['comments'] = $comments->getCommentsByImdbId($imdb_id);

		return $this->sendResponse($this->data, 'OK');
	}

	public function getCommentUser($id)
	{
		$user = new User;

		$this->data['user'] = $user->getUserById($id);

		return $this->sendResponse($this->data, "OK");
	}
}

<?php

namespace App\Http\Controllers\API;

use App\Comments;
use App\User;
use App\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VideosController extends APIController
{
	private $data = [];

	public function allComments($imdb_id)
	{
		$comments = new Comments;

		$this->data['comments'] = $comments->getCommentsByImdbId($imdb_id);

		foreach ($this->data['comments'] as &$val) {
		    $val['user'] = $val->user();
        }

		return $this->sendResponse($this->data, 'OK');
	}

	public function getCommentUser($id)
	{
		$user = new User;

		$this->data['user'] = $user->getUserById($id);

		return $this->sendResponse($this->data, "OK");
	}

	public function saveComment(Request $request)
	{
		$comment = new Comments;

		$comment->user_id = $request->user()->id;
		$comment->imdb_id = $request->imdb_id;
		$comment->comment = $request->comment;

		$comment->save();

		$this->data['comment'] = $comment;

		return $this->sendResponse($this->data, "OK");
	}

	public function insertToDB(Request $request)
	{
		Videos::updateOrCreate(
			['imdb_id' => $request->imdb_id, 'video' => $request->video_path, 'quality' => $request->quality],
			['updated_at' => Carbon::now()]
		);

		return $this->sendResponse("OK", "OK");
	}

	public function getVideoInfo(Request $request)
	{
//		$video = new Videos;
		$result = Videos::where(['imdb_id' => $request->imdb_id, 'quality' => $request->quality])->first();
//		$result = $video->where('imdb_id', $request->imdb_id)->get();

		return $this->sendResponse($result, "OK");
	}

	public function setDownloaded(Request $request)
	{
		$videos = Videos::where(['imdb_id' => $request->imdb_id, 'quality' => $request->quality])->first();
		$videos->downloaded = 1;

		$videos->save();

		return $this->sendResponse($videos, "Updated");
	}
}

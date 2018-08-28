<?php

namespace App\Http\Controllers\API;

use App\Viewed;
use Illuminate\Http\Request;

class UserController extends APIController
{
	public function isViewed(Request $request)
	{
		$viewed = new Viewed;

		$test = $viewed->isViewed($request->imdb_id, $request->video_id, $request->user()->id);
//		$test = $request->user()->id;

		return $this->sendResponse($test, 'OK');
	}

	public function viewed(Request $request)
	{
		$viewed = new Viewed;
		$imdb_id = $request->imdb_id;
		$video_id = $request->video_id;
		$user_id = $request->user()->id;
		$isViewed = $viewed->isViewed($imdb_id, $video_id, $user_id);

		if (!$isViewed) :
			$viewed->imdb_id = $imdb_id;
			$viewed->video_id = $video_id;
			$viewed->user_id = $user_id;

			$viewed->save();
		else :
			$viewed->findByIds($imdb_id, $video_id, $user_id);
			$viewed->delete();

			return $this->sendResponse($viewed, "OK");
		endif;

		return $this->sendResponse($viewed, "OK");
	}
}

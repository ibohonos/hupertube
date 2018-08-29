<?php

namespace App\Http\Controllers\API;

use App\Viewed;
use App\ViewLater;
use Illuminate\Http\Request;

class UserController extends APIController
{
	public function isViewed(Request $request)
	{
		$viewed = new Viewed;

		$test = $viewed->isViewed($request->imdb_id, $request->video_id, $request->user()->id);

		return $this->sendResponse($test, 'OK');
	}

	public function isViewLater(Request $request)
	{
		$view = new ViewLater;

		$test = $view->isViewLater($request->imdb_id, $request->video_id, $request->user()->id);

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
			$viewed = $viewed->findByIds($imdb_id, $video_id, $user_id);
			$viewed->truncate();

			return $this->sendResponse("Deleted!", "OK");
		endif;

		return $this->sendResponse($viewed, "OK");
	}

	public function viewLater(Request $request)
	{
		$view = new ViewLater;

		$imdb_id = $request->imdb_id;
		$video_id = $request->video_id;
		$user_id = $request->user()->id;
		$isViewed = $view->isViewLater($imdb_id, $video_id, $user_id);

		if (!$isViewed) :
			$view->imdb_id = $imdb_id;
			$view->video_id = $video_id;
			$view->user_id = $user_id;

			$view->save();
		else :
			$view = $view->findByIds($imdb_id, $video_id, $user_id);
			$view->truncate();

			return $this->sendResponse("Deleted!", "OK");
		endif;

		return $this->sendResponse($view, "OK");
	}

	public function allViewLater(Request $request)
	{
		$view = new ViewLater;

		$user_id = $request->user()->id;
		$allView = $view->allViewLater($user_id);

		return $this->sendResponse($allView, "OK");
	}
}

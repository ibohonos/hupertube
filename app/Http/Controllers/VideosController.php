<?php

namespace App\Http\Controllers;

use App\Videos;
use Carbon\Carbon;

class VideosController extends Controller
{
	private $data = [];

	public function index()
	{
		return view('videos.index');
	}

	public function show($id, $video_id)
	{
		$this->data['video'] = ['imdb_id' => $id, 'id' => $video_id];

		return view('videos.show', $this->data);
	}

	public function fileShow($movies, $imdb_id, $path, $file)
	{
		$path = $movies . '/' . $imdb_id .'/' . $path . '/' . $file;
		sleep(5);
		$stream = new VideoStreamController(public_path($path), 'mp4');
		return response()->stream(function() use ($stream) {
			$stream->start();
		});
	}

	public static function deleteOldFilms()
	{
		$videos = Videos::where('updated_at', '<', Carbon::now()->subMonth()->toDateString())->get();
		foreach ($videos as $video) :
			system('rm -rf \'' . public_path(dirname(urldecode($video->video))) . '\'');
			$video->delete();
		endforeach;
	}
}

<?php

namespace App\Http\Controllers;

use App\AllMovieIds;
use App\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
}

<?php

namespace App\Http\Controllers;

use App\AllMovieIds;
use App\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VideosController extends Controller
{
	private $data = [];

	public function index()
	{
		return view('videos.index');
	}

	public function add()
	{
		return view('videos.add');
	}

	public function store(Request $request)
	{
		dd($request->video->getMIMEType());
		$filename = time() . '-' . Auth::user()->first_name . '-' . Auth::user()->last_name . '.' . $request->video->extension();
		Storage::put('public/videos/' . $filename, file_get_contents($request->video));
		$videos = new Videos;

		$videos->user_id = Auth::id();
		$videos->category_id = 1;
		$videos->title = $request->title;
		$videos->description = $request->desc;
		$videos->image = "";
		$videos->video = $filename;

		$videos->save();
		return redirect()->back();
	}

	public function show($id, $video_id)
	{
//		$this->data['video'] = AllMovieIds::where('imdb_id', $id)->first();
		$this->data['video'] = ['imdb_id' => $id, 'id' => $video_id];

//		$url = "https://yts.am/api/v2/movie_details.json?movie_id=" . $id;
//		$options = array(
//			'https' => array(
//				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//				'method'  => 'GET'
//			)
//		);
//		$context  = stream_context_create($options);
//		$result = json_decode(file_get_contents($url), TRUE);
//		dd($result['data']['movie']);
//		$this->data['video'] = $result['data']['movie'];
		return view('videos.show', $this->data);
	}

	public function fileShow($file)
	{
		$path = 'public/videos/' . $file;
		if (Storage::disk('local')->exists($path)) {
			$type = Storage::disk('local')->mimeType($path);
			$stream = new VideoStreamController(storage_path('app/' . $path), $type);
			return response()->stream(function() use ($stream) {
				$stream->start();
			});
		}
		return response("File doesn't exists", 404);
	}
}

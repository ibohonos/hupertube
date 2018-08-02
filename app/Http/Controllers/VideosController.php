<?php

namespace App\Http\Controllers;

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

	public function show($id)
	{
		$this->data['video'] = Videos::findOrFail($id);

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

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
//	public $index;
//	public $source;
//	public $final_array;



//	function handler() {
//		$char = $this->source[$this->index];
//
//		if (is_numeric($char)) return $this->handler_string();
//		if ($char == 'i') {
//			++$this->index;
//			return $this->handler_int();
//		}
//		if ($char=='l') {
//			++$this->index;
//			return $this->handler_list();
//		}
//		if ($char=='d') {
//			++$this->index;
//			return $this->handler_dictonary();
//		}
//
//		die("MAIN HANDLER: UNEXPECTED CHAR (position: $this->index): ".$char);
//	}
//
//
//	function handler_int() {
//		$current_char='';
//		$number = "";
//
//		while (($current_char = $this->source[$this->index]) != 'e') {
//			++$this->index;
//			$number .= $current_char;
//		}
//
//		++$this->index;
//
//		return (int) $number;
//	}
//
//
//
//	function handler_string(){
//		$size ="";
//		while($this->source[$this->index] != ':') {
//			$size .= $this->source[$this->index];
//			++$this->index;
//		}
//
//		$i = ++$this->index;
//		$this->index += $size;
//
//		$x= substr($this->source, $i, $size);
//
//		return $x;
//	}
//
//	function handler_list() {
//		$return_list = array();
//
//		while ($this->source[$this->index] != 'e') {
//			$this->index1 = $this->index;
//			$return_list[] = $this->handler();
//			if ($this->index1 == $this->index) die("INFINITE LOOP IN THE LIST");
//		}
//		++$this->index;
//
//		return $return_list;
//	}
//
//	function handler_dictonary() {
//		$return_dict = array();
//
//		while ($this->source[$this->index] != 'e') {
//			$this->index1 = $this->index;
//			$return_dict[$this->handler_string()] = $this->handler();
//			if ($this->index1 == $this->index) die("INFINITE LOOP IN THE DICTONARY");
//		}
//		++$this->index;
//
//		return $return_dict;
//	}
//
//
//	function parse_file($filename) {
//		$this->source = file_get_contents($filename);
//
//		$this->index = 0;
//		$filesize = strlen($this->source);
//
//		$this->final_array=array();
//
//		while($this->index<$filesize) {
//			$this->index1 = $this->index;
//			$this->final_array[] =$this->handler();
//			if ($this->index1 == $this->index) die("INFINITE LOOP IN THE ROOT LIST");
//		}
//
//		$this->source = '';
//		return $this->final_array;
//	}



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
//		dd($request->video->getMIMEType());
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

//	function bdecode($str) {
//		$pos = 0;
//		return $this->bdecode_r($str, $pos);
//	}
//
//	function bdecode_r($str, &$pos) {
//		$strlen = strlen($str);
//		if (($pos < 0) || ($pos >= $strlen)) {
//			return null;
//		}
//		else if ($str{$pos} == 'i') {
//			$pos++;
//			$numlen = strspn($str, '-0123456789', $pos);
//			$spos = $pos;
//			$pos += $numlen;
//			if (($pos >= $strlen) || ($str{$pos} != 'e')) {
//				return null;
//			}
//			else {
//				$pos++;
//				return intval(substr($str, $spos, $numlen));
//			}
//		}
//		else if ($str{$pos} == 'd') {
//			$pos++;
//			$ret = array();
//			while ($pos < $strlen) {
//				if ($str{$pos} == 'e') {
//					$pos++;
//					return $ret;
//				}
//				else {
//					$key = $this->bdecode_r($str, $pos);
//					if ($key == null) {
//						return null;
//					}
//					else {
//						$val = $this->bdecode_r($str, $pos);
//						if ($val == null) {
//							return null;
//						}
//						else if (!is_array($key)) {
//							$ret[$key] = $val;
//						}
//					}
//				}
//			}
//			return null;
//		}
//		else if ($str{$pos} == 'l') {
//			$pos++;
//			$ret = array();
//			while ($pos < $strlen) {
//				if ($str{$pos} == 'e') {
//					$pos++;
//					return $ret;
//				}
//				else {
//					$val = $this->bdecode_r($str, $pos);
//					if ($val == null) {
//						return null;
//					}
//					else {
//						$ret[] = $val;
//					}
//				}
//			}
//			return null;
//		}
//		else {
//			$numlen = strspn($str, '0123456789', $pos);
//			$spos = $pos;
//			$pos += $numlen;
//			if (($pos >= $strlen) || ($str{$pos} != ':')) {
//				return null;
//			}
//			else {
//				$vallen = intval(substr($str, $spos, $numlen));
//				$pos++;
//				$val = substr($str, $pos, $vallen);
//				if (strlen($val) != $vallen) {
//					return null;
//				}
//				else {
//					$pos += $vallen;
//					return $val;
//				}
//			}
//		}
//	}
//
//	function bencode($var) {
//		if (is_int($var)) {
//			return 'i' . $var . 'e';
//		}
//		else if (is_array($var)) {
//			if (count($var) == 0) {
//				return 'de';
//			}
//			else {
//				$assoc = false;
//				foreach ($var as $key => $val) {
//					if (!is_int($key)) {
//						$assoc = true;
//						break;
//					}
//				}
//				if ($assoc) {
//					ksort($var, SORT_REGULAR);
//					$ret = 'd';
//					foreach ($var as $key => $val) {
//						$ret .= $this->bencode($key) . $this->bencode($val);
//					}
//					return $ret . 'e';
//				}
//				else {
//					$ret = 'l';
//					foreach ($var as $val) {
//						$ret .= $this->bencode($val);
//					}
//					return $ret . 'e';
//				}
//			}
//		}
//		else {
//			return strlen($var) . ':' . $var;
//		}
//	}


	public function show($id)
	{
		$this->data['video'] = Videos::findOrFail($id);

//		$test = Storage::get('public/videos/' . $this->data['video']->video);
//		$content_d = $this->bdecode($test);

//		dd($content_d);

//		$ttttt = $this->parse_file(storage_path('app/public/videos/' . $this->data['video']->video));

//		dd($ttttt);

//		$info_hash = sha1($this->bencode($content_d['info']), true);

//		dd($info_hash);
		//		dd($test);
//		dd(storage_path('app/public/videos/' . $this->data['video']->video));
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

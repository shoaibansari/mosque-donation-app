<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    protected $storagePath;

    public function __construct() {
        $this->storagePath = storage_path('app/');
    }
	
	public function serve($path) {
		$path = $this->storagePath . $path;
		
		if(is_dir($path) || !File::exists($path)) {
			abort(404);
		}
		
		try {
			$type = File::mimeType($path);
		} catch(\Exception $e) {
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			switch( strtolower($ext) ) {
				case 'gif':
					$type = 'image/gif';
					break;
				case 'jpg':
					$type = 'image/jpeg';
					break;
				case 'png':
					$type = 'image/png';
					break;
				case 'txt':
					$type = 'text/plain';
					break;
				case 'doc':
					$type = 'application/msword';
					break;
				default:
					$type = 'application/octet-stream';
			}
		}
		
		$file = File::get($path);
		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);
		
		return $response;
	}
	
}

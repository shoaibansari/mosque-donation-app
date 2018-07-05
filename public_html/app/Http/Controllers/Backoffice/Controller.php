<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth:admin');  // setting custom guard 'admin' here defined in app/auth.php
        $this->storagePath = 'uploads'. DIRECTORY_SEPARATOR . 'backoffice' . DIRECTORY_SEPARATOR;
    }

    protected function upload($file, $storagePath = '') {
        $storagePath = $this->storagePath . $storagePath;
        $filename = $file->getClientOriginalName();
//        $realpath = $file->getRealPath();
//        $mime     = $file->getMimeType();
//        $size     = $file->getSize();
//        $ext      = $file->getClientOriginalExtension();
        $userId   = auth('admin')->check() ? auth()->id() : 0;
        $prepend  = sprintf( '%07d-%s', $userId, time() );
        $filename = $prepend . $filename;
        $path     = storage_path($storagePath);
        $moved = $file->move( $path, $filename );
        return $filename;
    }
}

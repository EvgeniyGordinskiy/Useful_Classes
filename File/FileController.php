<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    protected $file_name;

    protected $file;

    public static $store_path_files = '/storage/app/upload';

    public static $max_file_size = '2000000';

    public static $allowed_extensions = [];

    public static $excepted_extensions = [];

    public function __construct (Request $request)
    {
        parent::__construct();

        $this->file = $this->checkFile($request);

        $this->checkFileSize();

        $ext = $this->checkExtension();

        $this->file_name = $this->file->getFilename() ? $this->file->getFilename(). ".$ext" : uniqid(Auth::user()->id). ".$ext";
    }

    public function store()
    {
        $this->file->move(base_path().static::$store_path_files, $this->file_name);

        return $this->file_name;
    }

    public function checkFile(Request $request)
    {
        if ( !$request->file || !$request->file->isValid() ) {
            abort(501,'Your file is broken');
        }

        return $request->file;
    }

    public function checkFileSize()
    {
        if ($this->file->getClientSize() > static::$max_file_size) {
            abort(413,'Overly large file size',['Accept' => static::$max_file_size]);
        }

        return true;
    }


    public function checkExtension()
    {
        if ( $ext = $this->file->guessExtension() ) {
            if (static::$allowed_extensions) {
                if ( !in_array($ext, static::$allowed_extensions) || in_array($ext, static::$excepted_extensions) ) {
                    abort(510,'' ,['Accept' => implode(',', static::$allowed_extensions)]);
                }
            }
        } else {
            abort(510,'' ,['Accept' => implode(',', static::$allowed_extensions)]);
        }

        return $ext;
    }
}
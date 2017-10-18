<?php
namespace App\Http\Controllers;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class FileController extends Controller
{
	protected $file_name;
	protected $file;
	public static $store_path_files = '/storage/app/upload';
	public static $max_file_size;
	public static $allowed_extensions = [];
	public static $excepted_extensions = [];

	/**
	 *  This method runs methods to check the size, extension,
	 *  integrity of the file and init property: $max_file_size, $file and $file_name.
	 *
	 * FileController constructor.
	 * @param Request $request
	 */
	public function __construct (Request $request)
	{
		parent::__construct();
		self::getSelfFileMaxSize();
		$this->file = $this->checkFile($request);
		$this->checkFileSize();
		$ext = $this->checkExtension();
		$this->file_name = $this->file->getFilename() ? $this->file->getFilename(). ".$ext" : uniqid(Auth::user()->id). ".$ext";
	}

	/**
	 * This method check property $max_file_size,
	 * and if it not exist we take property upload_max_filesize, from php.ini.
	 *
	 * @return mixed
	 */
	public static function getSelfFileMaxSize()
	{
		if ( !static::$max_file_size ) {
			static::$max_file_size = UploadedFile::getMaxFilesize();
		} elseif ( static::$max_file_size > UploadedFile::getMaxFilesize()) {
			abort(413,'$max_file_size largerer than the upload_max_filesize in php.ini');
		}

		return static::$max_file_size;
	}

	/**
	 * This method move file from tmp storage to the $store_path_files.
	 *
	 * @return string
	 */
	public function store()
	{
		$this->file->move(base_path().static::$store_path_files, $this->file_name);
		return ['file_name' => $this->file_name, 'orig_name' => $this->file->getClientOriginalName()];
	}

	/**
	 * This method checks the file for integrity.
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function checkFile(Request $request)
	{
		if ( !$request->file || !$request->file->isValid() ) {
			abort(501,'Your file is broken');
		}
		return $request->file;
	}

	/**
	 * Checking the size of the file.
	 *
	 * @return bool
	 */
	public function checkFileSize()
	{
		if ($this->file->getClientSize() > static::$max_file_size) {
			abort(413,'Overly large file size',['Accept' => static::$max_file_size]);
		}
		return true;
	}

	/**
	 * Check file extension
	 *
	 * @return mixed
	 */
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
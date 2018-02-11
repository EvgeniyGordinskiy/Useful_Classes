<?php

namespace App\Services\FileSystem;

use App\Services\Exceptions\FileException;

class File extends \SplFileObject
{
	/**
	 * File constructor.
	 * @param string $file
	 * @param string $open_mode
	 * @param bool $use_include_path
	 */
	public function __construct(string $file, string $open_mode, bool $use_include_path = false)
	{

		$path = dirname($file);
		if (!is_dir($path)) {
			$perm = substr(sprintf('%o', fileperms(dirname($path))), -3);
			if ($perm != 777) {
				chmod(dirname($path), 0777);
			}
			if (false === @mkdir($path, 0777, true)) {
				throw new FileException(sprintf('Unable to create the "%s" directory', $path));
			}
		}

		parent::__construct($file, $open_mode, $use_include_path);
	}
}
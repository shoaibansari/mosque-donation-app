<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/26/2016
 * Time: 5:54 AM
 */

namespace App\Classes\CToolBox;

class CFilesystemTool {

	/**
	 * @return CFilesystemTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CFilesystemTool();
		}

		return $instance;
	}

	/**
	 * Create directories according to PATH variable
	 * @param $path
	 * @return bool
	 */
	public function createPath( $path ) {
		if ( !file_exists($path) || !is_dir($path) ) {
			if ( !mkdir( $path, 0777, true ) ) {
				return false;
			}
		}
		return $path;
	}

	/**
	 * Get files from path
	 *
	 * @param $path
	 * @param null $startWith
	 * @param null $endWith
	 * @return array
	 * @throws \Exception
	 */
	public function getFiles( $path, $startWith = null, $endWith = null ) {

		if ( !file_exists( $path ) ) {
			throw new \Exception( 'Path does not exist' . (env( 'APP_DEBUG', true ) ? ': '.$path : '') );
		}

		if ( !is_dir( $path ) ) {
			throw new \Exception( 'Path does not a directory'. (env( 'APP_DEBUG', true ) ? ': ' . $path : '') );
		}

		$pattern = ($startWith || $endWith) ? $startWith . '*' . $endWith : '';

		return glob( $path . '/' . $pattern );
	}

	/**
	 * Delete files from a path
	 *
	 * @param $path
	 * @param null $startWith
	 * @param null $endWith
	 * @return bool
	 */
	public function deleteFiles( $path, $startWith=null, $endWith=null) {

		$files = $this->getFiles( $path, $startWith, $endWith );
		foreach( $files as $file ) {
			if ( file_exists($file) && !is_dir($file) ) {
				unlink($file);
			}
		}

		return true;

	}

}
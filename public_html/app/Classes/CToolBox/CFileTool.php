<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 12/1/2016
 * Time: 5:17 AM
 */

namespace App\Classes\CToolBox;

class CFileTool {

	/**
	 * @return CFileTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CFileTool();
		}

		return $instance;
	}

	/**
	 * @param $filePath
	 * @return bool
	 */
	public function exists( $filePath ) {
		return ( file_exists($filePath) && !is_dir($filePath) );
	}

	/**
	 * @abstract Rename file
	 * @param $file
	 * @param $new_name
	 * @param bool $formatName
	 * @return bool|string
	 */
	public function rename( $file, $new_name, $formatName = false ) {
		if (empty( $file ) || !file_exists( $file ) || is_dir( $file ) || empty( $new_name )) {
			return false;
		}
		$dir = pathinfo( $file )['dirname'];
		$new_name = $formatName ? $this->formatName( $formatName ) : $new_name;
		$new_file = $dir . DIRECTORY_SEPARATOR . $new_name;
		if (!rename( $file, $new_file )) {
			return false;
		}

		return $new_name;
	}
	
	/**
	 * @param $filename
	 * @param string $char
	 * @param bool $add_time
	 * @return string
	 */
	public function formatName($filename, $char = '-', $add_time = true) {
		$parts = explode(".", $filename);
		$ext = "";
		if(count($parts) > 1) {
			$ext = array_pop($parts);
			$filename = implode(".", $parts);
		}
		$filename = preg_replace("/([^0-9a-z])/i", $char, $filename);
		
		return preg_replace("/[" . preg_quote($char, "/") . "]{1,}/i", $char, $filename)
			. ($add_time ? "-" . time() : "")
			. ($ext ? "." . $ext : "");
	}
	
	/**
	 * @param $bytes
	 * @param int $decimals
	 * @return string
	 */
	public function readableFileSize( $bytes, $decimals = 1 ) {
		$size = array('Bytes','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}

	/**
	 * @param $val
	 * @return int
	 */
	public function fileSizeToBytes( $val ) {
		if (empty( $val ) || is_numeric( $val )) {
			return $val;
		}
		if ( preg_match('/(g|gb)$/i', $val) ) {
			$val *= pow( 1024, 3);
		}
		if (preg_match( '/(m|mb)$/i', $val )) {
			$val *= pow(1024, 2);
		}
		if (preg_match( '/(k|kb)$/i', $val )) {
			$val *= 1024;
		}
		return $val;
	}

    /**
     * @param $file
     * @return mixed
     */
    public function removeExtension( $file ) {
        return pathinfo( $file, PATHINFO_FILENAME );
    }
	
	/**
	 *
	 * @param $file
	 * @param $suffix
	 * @return string
	 */
    public function addSuffix( $file, $suffix ) {
    	$parts = explode(".", $file);
    	$ext = array_pop($parts);
    	return implode(".", $parts) . $suffix . '.' . $ext;
    }

}
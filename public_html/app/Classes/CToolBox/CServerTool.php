<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/28/2016
 * Time: 2:46 AM
 */

namespace App\Classes\CToolBox;

class CServerTool {

	/**
	 * @return CServerTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CServerTool();
		}

		return $instance;
	}

	/**
	 * @return int
	 */
	public function uploadFileSizeLimit(){

		$sizes = array(
			ini_get( 'upload_max_filesize' ),
			ini_get( 'post_max_size' ),
			ini_get( 'memory_limit' )
		);

		array_walk( $sizes, function ( &$val ) {
			$unit = strtoupper( substr( $val, -1, 1) );
			$val = intval( substr( $val, 0, -1) );
			switch ( $unit ) {
				case 'G':
					$val *= 1024;
				case 'M':
					$val *= 1024;
				case 'K':
					$val *= 1024;
			}
		});

		return min( $sizes );
	}


}
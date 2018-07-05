<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/27/2016
 * Time: 3:24 AM
 */

namespace App\Classes\CToolBox;

class CUrlTool {

	/**
	 * @return CUrlTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CUrlTool();
		}

		return $instance;
	}

	/**
	 * @param $position
	 * @return string|null
	 * @throws Exception
	 */
	function segment( $position ) {
		$segments = request()->segments();
		$count = count( $segments );
		$position = $position >= 0 ? $position : $count + $position;
		if ($position >= $count || $position < 0) {
			throw new Exception( 'Invalid segment position: ' . $position );
		}
		return $segments[ $position ];
	}

	/**
	 * @param $str
	 * @return mixed
	 */
	function formatSlug( $str ) {
		$str = preg_replace( '/[^\d\w]/i', '-', strtolower( $str ) );
		return trim(preg_replace( '/[\-]{1,}/', '-', $str ), '-');
	}

	// url()->formatSlug


}
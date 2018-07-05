<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/27/2016
 * Time: 2:25 AM
 */

namespace App\Classes\CToolBox;

class CDebugTool {

	/**
	 * @return CDebugTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CDebugTool();
		}

		return $instance;
	}




}
<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/26/2016
 * Time: 5:59 AM
 */

namespace App\Classes\CToolBox;

class CLogTool {

	/**
	 * @return CLogTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CLogTool();
		}

		return $instance;
	}

	public function error( $data, $label='' ) {
		return $this->_log('error', $data, $label, false, debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 30 ));
	}

	public function debug( $data, $label='' ) {
		return $this->_log( 'debug', $data, $label, false, debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 30 ) );
	}

	public function info( $data, $label='' ) {
		return $this->_log( 'info', $data, $label, false, debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 30 ) );
	}

	private function _log( $type, $data, $title, $return, $caller = null ) {
		$caller = $caller ? $caller : debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 30 );
		$info = PHP_EOL;
		$sep = str_repeat( "=", 60 ) . PHP_EOL;

		if (count( $caller ) > 0) {
			$info .= $sep;
			$info .= $caller[0]['file'] . ":" . $caller[0]['line'] . PHP_EOL;
			if ( !empty($title) ) {
				$info .= $title . PHP_EOL;
			}
			$info .= $sep;
		}

		if ( $return )
			return $info . $data ;

		if ($type == 'info')
			\Log::info( ['info' => $info, 'data' => $data ] );
		else if ($type == 'debug')
			\Log::debug( ['info' => $info, 'data' => $data ] );
		else
			\Log::error( ['info' => $info, 'data' => $data ] );
	}


}
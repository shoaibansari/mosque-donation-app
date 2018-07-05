<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 2/13/2018 7:16 PM
 */

namespace App\Classes\CToolBox;

class CVideoTool {

	protected $file = null;

	/*
	 *
	 */
	public static function instance( $file=null ) {
		static $instance;
		if ( !$instance ) {
			$instance = new CVideoTool( $file );
		}
		else {
			$instance->file( $file );
		}

		return $instance;
	}

	public function __construct( $file=null ) {
		$this->file = $file;
	}

	public function file( $file ) {
		$this->file = $file;
		return $this;
	}

	/**
	 * @param $file null
	 * @return CVideoStreamTool
	 */
	public function stream( $file=null ) {
		$file = is_null( $file ) ? $this->file : $file;

		static $videoStream;
		if ( !$videoStream ) {
			$videoStream = CVideoStreamTool::instance( $file );
		}
		else {
			$videoStream->file( $file );
		}

		$videoStream->start();
		return $videoStream;
	}

}
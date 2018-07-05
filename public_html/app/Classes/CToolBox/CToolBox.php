<?php
/**
 * User: Muhammad Adnan
 * Date: 11/26/2016
 * Time: 5:38 AM
 */

namespace App\Classes\CToolBox;

use App\Models\Settings;

class CToolBox {


	/**
	 * @return CToolBox
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CToolBox();
		}
		return $instance;
	}

	/**
	 * @param null $data
	 * @param bool $info
	 * @param null $label
	 * @return CLogTool
	 */
	public function log( $data=null, $info=true, $label=null ) {
		$instance = CLogTool::instance();
		if ( !is_null( $data) ) {
			if ($info)
				$instance->info( $data, $label );
			else
				$instance->error( $data, $label );
		}
		return $instance;
	}

	/**
	 * @return CRouteTool
	 */
	public function route() {
		return CRouteTool::instance();
	}


	/**
	 * @return CHtmlTool
	 */
	public function html() {
		return CHtmlTool::instance();
	}


	/**
	 * @return CFilesystemTool
	 */
	public function filesystem() {
		return CFilesystemTool::instance();
	}


	/**
	 * @return CDateTimeTool
	 */
	public function datetime() {
		return CDateTimeTool::instance();
	}


	/**
	 * @return CStringTool
	 */
	public function string() {
		return CStringTool::instance();
	}


	/**
	 * @return CArrayTool
	 */
	public function arrayTool() {
		return CArrayTool::instance();
	}


	/**
	 * @return CResponseTool
	 */
	public function response() {
		return CResponseTool::instance();
	}


	/**
	 * @return CCollectionTool
	 */
	public function collection() {
		return CCollectionTool::instance();
	}


	/**
	 * @return CNumberTool
	 */
	public function number() {
		return CNumberTool::instance();
	}


	/**
	 * @return CFileTool
	 */
	public function file() {
		return CFileTool::instance();
	}

	/**
	 * @param $imagePath
	 * @param bool $cache
	 * @return CImageTool
	 */
	public function image( $imagePath=null, $cache=true ) {
		return CImageTool::instance( $imagePath, $cache );
	}


	/**
	 * @return CUrlTool
	 */
	public function url() {
		return CUrlTool::instance();
	}

	/**
	 * Get access of global assets.
	 *
	 * @param $assetPath
	 * @return string
	 */
	public function asset( $assetPath ) {

		// NOTE: "frontend" section is nothing to do with the global assets.
		return $this->frontend()->globalAsset( $assetPath );
	}


	/**
	 * @param $section
	 * @return CThemeTool
	 */
	public function theme( $section ) {
		return CThemeTool::instance( $section );
	}
	
	
	/**
	 * Get global assets manager
	 *
	 * @param string $uri
	 * @return CPluginsManagerTool
	 */
	public function pluginsManager( $uri='/plugins' ) {
		$assetsBase = settings()->getAssetsBaseUrl() . ( $uri ? '/'.ltrim($uri,'/') : '' );
		return CPluginsManagerTool::instance( $assetsBase );
	}


	/**
	 * @return CServerTool
	 */
	public function server() {
		return CServerTool::instance();
	}

	/**
	 * @param string $field
	 * @param string $upload_path
	 * @param bool $ignoreDangerousFiles
	 * @return CUploadTool
	 */
	public function upload( $field='', $upload_path='', $ignoreDangerousFiles=true) {
		return CUploadTool::instance( $field, $upload_path, $ignoreDangerousFiles );
	}


	/**
	 * @return CFrontendTool
	 */
	public function frontend() {
		return CFrontendTool::instance();
	}

	/**
	 * @return CUserAreaTool
	 */
	public function userArea() {
		return CUserAreaTool::instance();
	}


	/**
	 * @return CBackendTool
	 */
	public function backend() {
		return CBackendTool::instance();
	}

	/**
	 * @return CIPTool
	 */
	public function ip() {
		return CIPTool::instance();
	}


	/**
	 * @return CEmailTool
	 */
	public function email() {
		return CEmailTool::instance();
	}

	/**
	 * @param $file
	 * @return CVideoTool
	 */
	public function video( $file=null ) {
		return CVideoTool::instance( $file );
	}

	/**
	 * @param $site
	 * @param int $timeout
	 * @return CScrapperTool
	 */
	public function scrapper($site=null, $timeout=3) {
		return CScrapperTool::instance( $site, $timeout );
	}


	/**
	 *
	 * @param null $key
	 * @param null $subKey
	 * @return Settings|bool|mixed|null
	 */
	public function settings( $key = null, $subKey = null ) {
		return Settings::instance( $key, $subKey );
	}


	/**
	 * Dump data
	 */
	public function dump() {
		// location and line
		$caller = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 1 );
		$info = count( $caller ) ? sprintf( "%s (%d)", $caller[0]['file'], $caller[0]['line'] ) : "*** Unable to parse location info. ***";

		// output
		$output = ["*FILE*" => $info,
		           '*DUMP*' => func_get_args()
		];

		// print output
		dump( $output );
	}


	/**
	 * Dump executed queries
	 *
	 * @param bool $last_query_only
	 * @param bool $remove_back_ticks
	 */
	public function dump_query( $last_query_only = true, $remove_back_ticks = true ) {

		// location and line
		$caller = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 1 );
		$info = count( $caller ) ? sprintf( "%s (%d)", $caller[0]['file'], $caller[0]['line'] ) : "*** Unable to parse location info. ***";

		// log of executed queries
		$logs = \DB::getQueryLog();
		if (empty( $logs ) || !is_array( $logs )) {
			$logs = "No SQL query found. *** Make sure you have enabled DB::enableQueryLog() ***";
		}
		else {
			$logs = $last_query_only ? array_pop( $logs ) : $logs;
		}

		// flatten bindings
		if (isset( $logs['query'] )) {
			$logs['query'] = $remove_back_ticks ? preg_replace( "/`/", "", $logs['query'] ) : $logs['query'];

			// updating bindings
			$bindings = $logs['bindings'];
			if (!empty( $bindings )) {
				$logs['query'] = preg_replace_callback(
					'/\?/', function ( $match ) use ( &$bindings ) {
					return "'" . array_shift( $bindings ) . "'";
				}, $logs['query']
				);
			}
		}
		else {
			if ( is_array($logs) ) {
				foreach($logs as &$log) {
					$log[ 'query' ] = $remove_back_ticks ? preg_replace("/`/", "", $log[ 'query' ]) : $log[ 'query' ];
					
					// updating bindings
					$bindings = $log[ 'bindings' ];
					if(!empty($bindings)) {
						$log[ 'query' ] = preg_replace_callback(
							'/\?/', function($match) use (&$bindings) {
							return "'" . array_shift($bindings) . "'";
						}, $log[ 'query' ]
						);
					}
				}
			}
		}

		// output
		$output = ["*FILE*" => $info,
		           '*SQL*'  => $logs
		];

		if ( request()->expectsJson() ) {
			print_r($output);
		}
		else {
			dump($output);
		}
	}

}



<?php
namespace App\Classes\CToolBox;

use Illuminate\Support\Facades\Route;

class CRouteTool {

	/**
	 * @return CRouteTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CRouteTool();
		}

		return $instance;
	}

	/**
	 * @param $route
	 * @return bool|string
	 */
	public function getActiveClassIfRoute( $route ) {
		$currentRouteName = Route::currentRouteName();
		if ( is_array( $route) ) {
			foreach( $route as $item ) {
				if ( $currentRouteName == $item ) {
					return ' active ';
				}
			}
			return '';
		}
		return $currentRouteName == $route ? ' active ' : '';
	}
	
	/**
	 * Get bool or class name if route is active.
	 *
	 * @param bool $returnClassName
	 * @param string $activeClassName
	 * @param string $inactiveClassName
	 * @return bool|string
	 * @throws \Exception
	 */
	public function isActive( $route, $returnClassName=false, $activeClassName='active', $inactiveClassName='' ) {
		
		$debugMode = env('APP_DEBUG', false);
		if ( !$map = config('routes-map' ) ) {
			$details = $debugMode ? '. Technical: routes-map.php file is missing from the config directory' : '.';
			throw new \Exception('Route map file is missing'. $details);
		}
		
		if ( !is_array($map) ) {
			throw new \Exception('Expecting an array type');
		}
		
		$currentRoute = Route::currentRouteName();
		if ( $route == $currentRoute ) {
			return $returnClassName ? $activeClassName : true;
		}
		
		if( !array_key_exists($route, $map) ) {
			return $returnClassName ? $inactiveClassName : false;
		}
		
		if( !in_array($currentRoute, $map[ $route ])) {
			return $returnClassName ? $inactiveClassName : false;
		}
		
		return $returnClassName ? $activeClassName : true;
	}





}
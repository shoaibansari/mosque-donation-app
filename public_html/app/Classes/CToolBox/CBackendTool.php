<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/27/2016
 * Time: 3:41 AM
 */

namespace App\Classes\CToolBox;
use App\Classes\CToolBox\ThemesFactory\CMaterialTheme;
use App\Classes\CToolBox\ThemesFactory\CMetronicTheme;
use App\Settings;

class CBackendTool extends CThemeTool {

	/**
	 * @return CBackendTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CBackendTool( CThemeTool::SECTION_BACKEND );
		}

		return $instance;
	}

	public function __construct( $section ) {
		parent::__construct( $section );
	}

	/**
	 * @return CMetronicTheme|CMaterialTheme
	 */
	public function themeHelper() {
		if ( $this->themeName() == 'default' || $this->themeName() == 'material' )
			return CMaterialTheme::instance();
		else
			return CMetronicTheme::instance();
	}

	public function url( $path="", $secure=null ) {
		return settings()->getAdminUrl( $secure ) . ltrim( $path, '/' );
	}


}
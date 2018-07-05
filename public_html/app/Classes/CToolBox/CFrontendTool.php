<?php
namespace App\Classes\CToolBox;

use App\Classes\CToolBox\ThemesFactory\CMaterialTheme;
use App\Classes\CToolBox\ThemesFactory\CMetronicTheme;

class CFrontendTool extends CThemeTool {

	public function __construct( $section, $isAssetsOnRoot = false ) {
		parent::__construct( $section, $isAssetsOnRoot );

	}

	/**
	 * @return CFrontendTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CFrontendTool( CThemeTool::SECTION_FRONTEND );
		}
		return $instance;
	}
	
	/**
	 * @return CMetronicTheme|CMaterialTheme
	 */
	public function themeHelper() {
		if($this->themeName() == 'default' || $this->themeName() == 'material') {
			return CMaterialTheme::instance();
		}
		else {
			return CMetronicTheme::instance();
		}
	}
	
	public function url($path = "", $secure = null) {
		return rtrim(settings()->getUrl($secure), '/') . '/'. ltrim($path, '/');
	}
	
}
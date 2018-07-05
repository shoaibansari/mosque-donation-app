<?php
namespace App\Classes\CToolBox;

class CUserAreaTool extends CThemeTool {

	public function __construct( $section, $isAssetsOnRoot = false ) {
		parent::__construct( $section, $isAssetsOnRoot );

	}

	/**
	 * @return CUserAreaTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CUserAreaTool( CThemeTool::SECTION_USERS_AREA );
		}
		return $instance;
	}

}
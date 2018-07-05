<?php
namespace App\Classes\CToolBox;


class CThemeTool {

	const SECTION_FRONTEND = 'frontend';
	const SECTION_BACKEND = 'backoffice';
	const SECTION_USERS_AREA = 'users-area';

	public $isAssetsOnRoot = false;

	public function __construct( $section, $isAssetsOnRoot = false) {
		$this->section = $section;
		$this->isAssetsOnRoot = $isAssetsOnRoot;
		$this->themeName = settings()->item( 'theme.' . $this->section );
		if ( !$this->themeName ) {
			throw new \Exception( '"theme.' . $this->section . '" key is not available in settings.');
		}
		$this->pluginsManager = new CPluginsManagerTool( $this->item( 'asset') );

	}

	public function themeName() {
		return $this->themeName;
	}

	public function request( $request ) {
		return $this->item( 'request', $request );
	}

	public function layout( $layout ) {
		return $this->item( 'layout', $layout );
	}

	public function view( $view ) {
		return $this->item( 'view', $view );
	}

	public function assetsBase() {
//		if ( env( 'APP_ASSETS_URL' ) )
//			return rtrim( env( 'APP_ASSETS_URL' ), '/' );
//		return rtrim( url( '' ), '/' );
		return settings()->getAssetsBaseUrl();
	}

	public function globalAsset( $asset ) {
		return $this->assetsBase() . '/' . ltrim( $asset, "/" );
	}

	public function asset( $asset, $mix=false ) {
		return $this->item( 'asset', $asset, $mix );
	}
	
	public function assetsUrl() {
		return $this->item( 'asset' );
	}

	public function title( $title ) {
		return $title . ( !empty($title) ? ' - ' : '') . settings()->getAppName();
	}

	/**
	 * @return CPluginsManagerTool
	 */
	public function pluginsManager() {
		return $this->pluginsManager;
	}

	public function url( $path='', $secure=null ) {
		return url( $path, null, $secure );
	}

	public function settings( $key = null ) {
		static $store;
		$section = $this->section;

		if ( empty( $section) ) {
			throw new \Exception('Section not specified.');
		}

		if (!$store) {
			$store = [];
		}
		if (!array_key_exists( $section, $store )) {
			$viewsPath = config( 'view.paths' )[0];
			$paths[] = $viewsPath;
			$paths[] = $section;
			$paths[] = settings()->item( 'theme.' . $section );
			$paths[] = 'settings.php';
			$settingsFile = implode( DIRECTORY_SEPARATOR, $paths );
			if (!file_exists( $settingsFile )) {
				return null;
			}
			include_once($settingsFile);
			if (!isset($settings) || !$settings || !is_array( $settings )) {
				return null;
			}
			$store[ $section ] = array_dot( $settings );

		}
		$settings = $store[ $section ];
		if (!is_null( $key )) {
			return array_key_exists( $key, $settings ) ? $settings[ $key ] : null;
		}

		return $settings;
	}


	private function item( $type, $item="", $mix=false ) {

		$theme = $this->themeName();

		if ($type == 'view') {
			return $this->section . '.' . $theme . '.' . $item;
		}

		if ($type == 'layout') {
			return $this->section . '.' . $theme . '.layouts.' . $item;
		}

		if ($type == 'asset') {

			$assetsBase = $this->assetsBase();

			if ( !$this->isAssetsOnRoot ) {
				$assetsPath = '/' . str_replace( ".", "/", $this->section ) . '/' . $theme . '/' . ltrim( $item, '/' );
			}
			else {
				$assetsPath = '/' . ltrim( $item, '/' );
			}

			if ( $mix ) {
				$assetsPath = mix( $assetsPath );
			}

			return $assetsBase . $assetsPath ;
		}

		if ( $type == 'request' ) {
			if( $this->section == self::SECTION_BACKEND ) {
				return 'App\Http\Requests\Backoffice\\' . $item;
			}
			else if ( $this->section == self::SECTION_FRONTEND ) {
				return 'App\Http\Requests\Frontend\\' . $item;
			}
			else if ( $this->section == self::SECTION_USERS_AREA ) {
				return 'App\Http\Requests\UsersArea\\' . $item;
			} else {
				throw new \Exception('Unhandled section');
			}
		}

		return null;
	}
	
	

	private $section, $themeName, $pluginsManager;

}
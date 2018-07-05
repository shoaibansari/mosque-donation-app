<?php
namespace app\Classes\CToolBox;

class CPluginsManagerTool {

	private $base, $plugins=[], $files;

	public function __construct( $base='' ) {
		$this->base = rtrim( $base, "/" ) . "/";
	}

	public static function instance( $base = '') {
		static $instance;
		if ( !$instance ) {
			$instance=new CPluginsManagerTool( $base );
		}
		return $instance;
	}

	public function base(  $assetsBaseUrl ) {
		$this->base = rtrim($assetsBaseUrl, "/") . "/";
		return $this;
	}

	public function plugins( $plugins ) {
		if ( empty($plugins) )
			return;
		if ( is_scalar($plugins))
			$plugins = (array) $plugins;

		$this->plugins = array_merge( $plugins, $this->plugins );
	}

	public function renderStylesheets() {
		$this->files = $this->getFiles( $this->plugins );
		$ss = [];
		foreach( $this->files['stylesheet'] as $file)  {
			$ss[] = '<link href="'. $file .'" rel="stylesheet" type="text/css" />';
		}

		return implode(PHP_EOL, $ss);
	}

	public function renderScripts() {
		$this->files = $this->getFiles( $this->plugins );
		$ss = [];
		foreach ($this->files['script'] as $file) {
			if ( is_array($file) ) {
				$props = [];
				foreach( $file as $p => $v ) {
					$props[] = $p . '="' . $v . '"';
				}
				$ss[] = '<script ' . implode(" ", $props) . '></script>';
			}
			else {
				$ss[] = '<script src="' . $file . '" type="text/javascript"></script>';
			}
		}

		return implode( PHP_EOL, $ss );
	}


	private function getFiles( $plugins ) {

		$files['script'] = [];
		$files['stylesheet'] = [];
		
		foreach( $plugins as $plugin ) {
			switch ($plugin) {

				case 'datatables':
					$files['stylesheet'][] = $this->base . 'jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css';
					$files['stylesheet'][] = $this->base . 'jquery-datatable/skin/bootstrap/css/additional.css';
					$files['stylesheet'][] = $this->base . 'jquery-datatable/extensions/export/buttons.dataTables.min.css';
					$files['script'][] = $this->base . 'jquery-datatable/jquery.dataTables.js';
					$files['script'][] = $this->base . 'jquery-datatable/extensions/export/dataTables.buttons.min.js';
					$files['script'][] = $this->base . 'jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js';
					$files['script'][] = $this->base . 'jquery-datatable/extensions/export/buttons.flash.min.js';
					$files['script'][] = $this->base . 'jquery-datatable/extensions/export/jszip.min.js';
					$files['script'][] = $this->base . 'jquery-datatable/extensions/export/pdfmake.min.js';
					$files['script'][] = $this->base . 'jquery-datatable/extensions/export/vfs_fonts.js';
					$files['script'][] = $this->base . 'jquery-datatable/extensions/export/buttons.html5.min.js';
					$files['script'][] = $this->base . 'jquery-datatable/extensions/export/buttons.print.min.js';
					$files['script'][] = $this->base . 'jquery-datatable/buttons.server-side.js';
					break;
					
				case 'bs-table':
					$files['stylesheet'][] = $this->base . 'bootstrap-table/bootstrap-table.min.css';
					$files['script'][] = $this->base . 'bootstrap-table/bootstrap-table.min.js';
					$files['script'][] = $this->base . 'bootstrap-table/bootstrap-table-locale-all.min.js';
					$files['script'][] = $this->base . 'bootstrap-table/extensions/reorder-columns/bootstrap-table-reorder-columns.js';
					break;
					
				case 'bs-daterangepicker-2.0':
					$files['stylesheet'][] = $this->base . 'bootstrap.daterangepicker/2/daterangepicker.css';
					$files['script'][] = $this->base . 'momentjs/moment.min.js';
					$files['script'][] = $this->base . 'bootstrap.daterangepicker/2/daterangepicker.js';
					break;
					
				case 'js-validation':
					$files['script'][] = $this->base . 'jsvalidation/js/jsvalidation.js';
					break;
				
				case 'bs-select':
					$files['stylesheet'][] = $this->base . 'bootstrap-select/css/bootstrap-select.css';
					$files['script'][] = $this->base . 'bootstrap-select/js/bootstrap-select.js';
					break;
					
				case 'chosen':
					$files['stylesheet'][] = $this->base . 'chosen/chosen.min.css';
					$files['script'][] = $this->base . 'chosen/chosen.jquery.min.js';
					break;
				
				case 'select2':
					$files['stylesheet'][] = $this->base . 'select2/css/select2.min.css';
					$files['script'][] = $this->base . 'select2/js/select2.full.min.js';
					break;
					
				case 'fileinput':
					$files['stylesheet'][] = $this->base . 'bootstrap-fileinput/css/fileinput.min.css';
					$files['stylesheet'][] = $this->base . 'bootstrap-fileinput/themes/explorer/theme.min.css';
					$files['script'][] = $this->base . 'bootstrap-fileinput/js/plugins/piexif.min.js';
					$files['script'][] = $this->base . 'bootstrap-fileinput/js/plugins/purify.min.js';
					$files['script'][] = $this->base . 'bootstrap-fileinput/js/fileinput.js';
					$files['script'][] = $this->base . 'bootstrap-fileinput/themes/fa/theme.js';
					break;
					
				case 'tinymce':
					$files['script'][] = $this->base . 'tinymce/tinymce.js';
					break;
				
				case 'pixie':
					$files['script'][] = [
						'src' => $this->base . 'pixie/pixie-integrate.js',
						'data-path' => $this->base . 'pixie',
						'data-preload' => 'true'
					];
					break;
					
				default:
					throw new \Exception('Undefined plugin: '. $plugin);

			}
		}

		return $files;

	}

}
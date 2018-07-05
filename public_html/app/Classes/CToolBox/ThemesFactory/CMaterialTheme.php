<?php
namespace App\Classes\CToolBox\ThemesFactory;

class CMaterialTheme
{

	private function __construct() {
	}

	/**
	 * Get instance
	 *
	 * @return CMetronicTheme
	 */
    public static function instance() {
        static $instance;
        if ( !$instance ) {
            $instance = new CMaterialTheme();
        }
        return $instance;
    }

	/**
	 * Created bread-crumb
	 *
	 * @param $data
	 * @param null $class
	 * @param null $separator
	 * @return string
	 */
	public function breadcrumb( $data, $class=null, $separator=null ) {
		$breadcrumb = '<ol class="'.( $class ? $class : 'breadcrumb' ) .'">';
		$size = count($data);
		$i = 0;
		foreach ( $data as $name => $url ) {
			
			$firstIteration = $i === 0;
			$lastIteration = ($size - $i)  == 1;
			
			if ( !$url || $lastIteration ) {
				$url = 'javascript:;';
			}
			
			$active = '';
			if ( $lastIteration ) {
				$active='active';
			}
			
			$breadcrumb .= '<li class="'. $active .'">';
			
			if ( $firstIteration ) {
				$breadcrumb .= '<a href="' . $url . '">';
				$breadcrumb .= '<h2>'.$name.'</h2>';
				$breadcrumb .= '</a>';
			}
			else if ( $lastIteration ) {
				$breadcrumb .= $name;
			}
			else {
				$breadcrumb .= '<a href="'. $url . '">';
				$breadcrumb .= $name;
				$breadcrumb .= '</a>';
			}
			
			if ( !$lastIteration && !is_null($separator) ) {
				$breadcrumb .= $separator;
			}
			$breadcrumb .= '</li>';
			$i++;
		}
		return $breadcrumb . '</ol>';
	}

	

}
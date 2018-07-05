<?php
namespace App\Classes\CToolBox\ThemesFactory;

use Illuminate\Support\Facades\Session;
use App\NavigationItem;
use Collective\Html\FormFacade as Form;

class CMetronicTheme
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
            $instance = new CMetronicTheme();
        }
        return $instance;
    }

	/**
	 * Returns multi-dimensional array in child-parent format.
	 *
	 * @return array
	 */
    public function sidebar( ) {
	    $role_id = auth()->check() ? auth()->user()->role_id : 0; // checking auth
	    $navigation_id = 1;     // for admin
	    //$items = NavigationItem::where('navigation_id', $navigation_id)->where('role_id', '>=', $role_id)->get()->toArray();
	    $items = NavigationItem::where('navigation_id', $navigation_id)->get()->toArray();
	    if ( !$items || count($items) == 0 ) {
			return [];
		}
	    $items = $this->doSidebarProcess( $items );
		//dd( $items );
	    return $items;
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
		$breadcrumb = '<ul class="'.( $class ? $class : 'page-breadcrumb' ) .'">';
		$size = count($data);
		foreach ( $data as $name => $url ) {
			$lastItem = $size-- == 1;
			$breadcrumb .= '<li><a href="'. ($lastItem ? 'javascript:;' : $url) . '">'. $name ."".'</a>';
			if ( !$lastItem ) {
				$breadcrumb .= $separator ? $separator : '<i class="fa fa-circle"></i>';
			}
			$breadcrumb .= '</li>';
		}
		return $breadcrumb . '</ul>';
	}

	/**
	 * Shows alert message or creates an empty alert container for message.
	 *
	 * @param null $errors
	 * @param bool $onlyFirst
	 * @return string
	 */
	public function alertMessage( $errors=null, $onlyFirst=false ) {

//		$options['danger'] = ['class'=>'alert-danger', 'icon'=>'fa-exclamation-triangle'];
//		$options['warning'] = ['class'=>'alert-warning', 'icon'=>'fa-warning'];
//		$options['success'] = ['class'=>'alert-success', 'icon'=>'fa-check'];
//		$options['info'] = ['class'=>'alert-info', 'icon'=>'fa-info-circle'];

		$html[] = '<div class="alert-container">';

		// error handling for views
		if ( !is_null($errors) && count($errors) > 0 ) {
			if ( count($errors) == 1 )
				$onlyFirst = true;
			$html[] = '<div class="alert alert-danger">';
			$html[] = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
			$html[] = '<i class="fa-lg fa fa-exclamation-triangle"></i>';
			if (!$onlyFirst)
				$html[] = '<ul>';
			foreach ( $errors->all() as $error) {

				if ($onlyFirst) {
					$html[] = '&nbsp;'.$error;
					break;
				};
				$html[] = '<li>' . $error . '</li>';
			}
			if (!$onlyFirst)
				$html[] = '</ul>';
			$html[] = '</div>';
		}
		else if ( Session::has( 'message' ) ) {
			$html[] = '<div class="alert alert-info">';
			$html[] = '		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
			$html[] = '		<strong><i class="fa-lg fa fa-info-circle"></i></strong> ' . Session::get( 'message' );
			$html[] = '</div>';
		}
		else {
			foreach ( ['danger', 'warning', 'success', 'info'] as $msg ) {
				if ( Session::has( 'alert-' . $msg )) {
					switch($msg) {
						case 'danger': $icon = '<i class="fa-lg fa fa-exclamation-triangle"></i>'; break;
						case 'warning': $icon = '<i class="fa-lg fa fa-warning"></i>'; break;
						case 'success': $icon = '<i class="fa-lg fa fa-check"></i>'; break;
						case 'info': $icon = '<i class="fa-lg fa fa-info-circle"></i>'; break;
					}
					$html[] = '<div class="alert alert-' . $msg . '">';
					$html[] = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
					$html[] = '<strong>'. $icon .'</strong> '.Session::get( 'alert-' . $msg );
					$html[] = '</div>';
					break;
				}
			}
		}
		$html[] = '</div>';
		return implode( "", $html );
	}

	/**
	 * Creates hyper link.
	 *
	 * @param $text
	 * @param string $url
	 * @param array $properties
	 * @return string
	 */
	public static function href( $text, $url = 'javascript:;', $properties = [] ) {
		$parts = [];
		if (is_array( $properties )) {
			foreach ($properties as $property => $value) {
				$parts[] = $property . '="' . $value . '"';
			}
		}

		return sprintf( '<a href="%s" %s>%s</a>', $url, implode( " ", $parts ), $text );

	}

	public function switchButton( $id, $name, $data, $checked=true, $colors=array() ) {
		$values = array_keys( $data );
		$offValue = $values[0];
		$onValue = $values[1];
		$offLabel = $data[ $offValue ];
		$onLabel = $data[ $onValue ];
		$offColor = '';
		$onColor = '';
		if ( is_array($colors) && count($colors) >= 2) {
			$offColor = ' data-off-color="' . $colors[0] . '"';
			$onColor = ' data-on-color="' . $colors[1] . '"';
		}
		$checked = $checked ? ' checked="checked"' : "";
		return '<input id="active" 
			class="make-switch form-control" 
			data-size="small" 
			data-on="' . $onValue . '" 
			data-off="' . $offValue . '" 
			data-on-text="' . $onLabel . '" 
			data-off-text="' . $offLabel . '" 
			' . $checked . '" 
			' . $offColor . '" 
			' . $onColor . '" 
			id="' . $id . '" 
			name="' . $name . '" 
			type="checkbox" 
			value="' . $onValue . '">';
	}

	public function groupButton( $options, $title="", $class="green" ) {

		if ( !$options || !is_array($options) ) {
			return null;
		}

		$links = "";
		foreach( $options as $option) {
			$links .= '<li>';
			$attributes = "";
			if ( isset($option['attributes']) ) {
				foreach($option['attributes'] as $attr => $value) {
					$attributes .= ' '.$attr.'="'. $value . '"';
				}
			}
			$option['url'] = isset($option['url']) ? $option['url'] : "javascript:;";
			$links .= '<a href="'. $option['url'] . '" '. $attributes .'>';
			if ( isset($option['icon']) ) {
				$links .= '<i class="'. $option['icon'] .'"></i> ';
			}
			$links .= $option['title'] . '</a></li>';
		}
		$html = <<<Block
			<div class="btn-group">
		        <a class="btn $class" href="javascript:;" data-toggle="dropdown">
		            <i class="fa fa-bars"></i> $title
		            <i class="fa fa-angle-down"></i>
		        </a>
		        <ul class="dropdown-menu pull-right">
		            $links
		        </ul>
	    </div>
Block;
		return $html;
	}

	public function select2( $id, $name, $selected=array(), $attributes=array() ) {

		$default = ['class' => 'form-control', 'buttons'=>['default'] ];
		if ( !is_array($attributes) ) {
			$attributes = array();
		}

		$attributes = array_merge( $default, $attributes );
		$attributes['id'] = $id;

		$buttons = [];
		if ( isset($attributes['buttons']) ) {
			$buttons = $attributes['buttons'];
			unset($attributes['buttons']);
		}

		$element = Form::select( $name, $selected, array_keys($selected), $attributes);

		$buttonsHtml = '';
		if ( is_array($buttons) ) {
			foreach($buttons as $button) {
				if ( is_array($button) ) {
					$btn = '<button ';
					foreach($button as $attr => $val) {
						$btn .= $attr .'="'. $val.'" ';
					}
					$btn .= '>';
					if ( isset($button['title']) ) {
						$btn .= $button['title'];
					}
					$btn .= '</button>';
					$buttonsHtml .= $btn;
				}
				else if ( strtolower($button) == 'default') {
					$buttonsHtml .= '<button class="btn btn-default" type="button" data-select2-open="'. $id . '"><span class="glyphicon glyphicon-search"></span></button>';
				}
			}
		}
		return <<<Block
			<div class="input-group select2-bootstrap-append">			
	            $element
	            <span class="input-group-btn">
	                $buttonsHtml
	            </span>
	        </div>
Block;
	}

	/**
	 * @param bool $return
	 * @return string
	 */
	public function fieldRequired( $return=false ) {
		//$html = '<span class="required">*</span>';
		$html = '<i class="fa fa-star" style="font-size: 8px; color: lightgrey"></i>';
		if ( $return )
			return $html;
		echo $html;
	}

	/**
	 * Process and returns multi-dimensional array
	 *
	 * @param $items
	 * @param int $parent
	 * @return array
	 */
	private function doSidebarProcess( $items, $parent = 0 ) {
		$sidebar = [];
		foreach ($items as $item) {
			if ($item['parent'] == $parent) {
				$children = $this->doSidebarProcess( $items, $item['id'] );
				if ($children) {
					// sorting
					$item['children'] = array_values( array_sort($children, function ( $value ) {
						return $value['display_order'];
					}));

				}
				$sidebar[] = $item;
			}
		}

		return $sidebar;
	}

}
<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/26/2016
 * Time: 5:42 AM
 */

namespace App\Classes\CToolBox;

class CHtmlTool {

	/**
	 * @return CHtmlTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CHtmlTool();
		}

		return $instance;
	}
	
	/**
	 * Creates hyper link.
	 *
	 * @param $text
	 * @param string $href
	 * @param array $properties
	 * @return string
	 */
	public function anchor($text, $href = 'javascript:;', $properties = []) {
		$properties['href'] = $href;
		return $this->createTag('a', $text, $properties);
	}
	
	/**
	 * Create a tag
	 *
	 * @param $tag
	 * @param string $contents
	 * @param array $properties
	 * @return string
	 */
	public function createTag($tag, $contents='', $properties = []) {
		$parts = [];
		if(is_array($properties)) {
			foreach($properties as $property => $value) {
				$parts[] = $property . '="' . $value . '"';
			}
		}
		
		if ( in_array(strtolower($tag), ['br', 'img', 'link']) ) {
			return sprintf('<%s %s/>', $tag, implode(" ", $parts));
		}
		
		return sprintf('<%s %s>%s</%s>', $tag, implode(" ", $parts), $contents, $tag);
	}
	
	/**
	 * Remove a tag
	 *
	 * @param $tags
	 * @param $string
	 * @param bool $withContents
	 * @return string
	 */
	public function removeTags($string, $tags, $withContents=true) {
		if($withContents) {
			if ( is_array($tags) ) {
				foreach( $tags as $tag ) {
					$string = preg_replace("#<$tag(.*?| .*?)/$tag>#ims", "", $string);
				}
			}
			else {
				$string = preg_replace("#<$tags(.*?| .*?)/$tags>#ims", "", $string);
			}
			
			return $string;
		}
		
		if(is_array($tags)) {
			foreach($tags as $tag) {
				$string = preg_replace("#<$tag .*?)>#ims", "", $string);
				$string = preg_replace("#</.*?$tag>#ims", "", $string);
			}
		}
		else {
			$string = preg_replace("#<$tags .*?)>#ims", "", $string);
			$string = preg_replace("#</.*?$tags>#ims", "", $string);
		}
		
		return $string;
	}
	
	
	public function removeTagProperties($mixed, $onlyEvents=false) {
		if( is_array($mixed) ) {
			foreach($mixed as $k => $v) {
				$mixed[ $k ] = $this->removeTagProperties($v, $onlyEvents);
			}
		}
		else {
			$mixed = preg_replace('/<(.*?) '. ($onlyEvents ? "on" : "") .'(.*?)>/ims', '<$1>', $mixed);
		}
		
		return $mixed;
	}

	/**
	 *
	 *
	 * @param $tags
	 * @param $replaceWith
	 * @param $string
	 * @param bool $includeTags
	 * @return mixed
	 */
	public function alterTags($string, $tags, $removeProperties=false, $removeContents=false ) {
		
		if ( $tags )
		if ($removeContents) {
			return preg_replace("#<($tags)(.*?| .*?)/($tags)>#ims", "$replaceWith", $string );
		}

		return preg_replace("#<($tags)(.*?| .*?)/($tags)>#ims", "<$1>$replaceWith</$3>", $string );
	}

	/**
	 * @param $array
	 * @param array $parentAttributes
	 * @param null $selectItemHasValue
	 * @param array $selectedItemAttributes
	 * @param string $listType
	 * @return bool|string
	 */
	public static function createList( $array, $parentAttributes = array(), $selectItemHasValue = null, $selectedItemAttributes = array(), $listType='ul' ) {

		if (!is_array( $array )) {
			return false;
		}

		$temp = "";
		if (is_array( $parentAttributes )) {
			foreach ($parentAttributes as $name => $value) {
				$temp .= $name . '="' . $value . '" ';
			}
		}
		$parentAttributes = $temp;

		$ot = "<$listType $parentAttributes>";
		$et = "</$listType>";

		$html = $ot;
		foreach ($array as $item) {
			if (!is_null( $selectItemHasValue ) && $item == $selectItemHasValue) {
				$itemAttributes = "";
				if (is_array( $selectedItemAttributes )) {
					foreach ($selectedItemAttributes as $name => $value) {
						$itemAttributes .= $name . '="' . $value . '" ';
					}
				}
				$html .= sprintf( '<li %s>%s</li>', $itemAttributes, $item );
			}
			else {
				$html .= sprintf( '<li>%s</li>', $item );
			}
		}
		$html .= $et;
		return $html;
	}

	/**
	 * @param $flat array
	 * @param $pidKey
	 * @param null $idKey
	 * @return mixed
	 */
	public static function buildTree( $flat, $pidKey, $idKey = null ) {
		$grouped = array();
		foreach ( $flat as $sub ) {
			$grouped[ $sub[ $pidKey ] ][] = $sub;
		}

		$fnBuilder = function ( $siblings ) use ( &$fnBuilder, $grouped, $idKey ) {
			foreach ( $siblings as $k => $sibling ) {
				$id = $sibling[ $idKey ];
				if ( isset( $grouped[ $id ] ) ) {
					$sibling[ 'children' ] = $fnBuilder( $grouped[ $id ] );
				}
				$siblings[ $k ] = $sibling;
			}

			return $siblings;
		};

		$tree = $fnBuilder( $grouped[ 0 ] );

		return $tree;
	}
	
	/**
	 * Purify HTML from malicious tags and properties
	 *
	 * @param $html
	 * @return string
	 */
	public function sanitize( $html ) {
		$html = $this->removeTagProperties( $html, true);
		return $this->removeTags($html, ['iframe', 'script', 'applet', 'frame', 'frameset']);
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 12/7/2016
 * Time: 9:17 PM
 */

namespace App\Classes\CToolBox;

class CArrayTool {

	/**
	 * @return CArrayTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CArrayTool();
		}

		return $instance;
	}
	

	/**
	 * @param $array
	 * @param $index
	 * @param bool $duplicate
	 * @param bool $removeIndex
	 * @return array
	 *
	 */
	public function createByIndexValue($array, $index, $duplicate=false, $removeIndex=true) {
		$output = array();
		foreach ($array as $key => $item) {
			if ( !array_key_exists( $index, $item ) )
				continue;
			$indexValue = $item[$index];
			if ($removeIndex)
				unset($item[$index]);
			if ( $duplicate ) {
				$output[$indexValue][] = $item;
			} else {
				$output[$indexValue] = $item;
			}
		}
		return $output;
	}

	public function hasAll( $requiredItems, $listItems, $compareByValue = true ) {
		return count( $this->compare( $requiredItems, $listItems, $compareByValue) ) == 0;
	}

	public function compare( $requiredItems, $listItems, $compareByValue=true ) {
		$missingItems = [];
		foreach( $requiredItems as $key => $item ) {
			if ( $compareByValue ) {
				if ( !in_array( $item, $listItems ) ) {
					$missingItems[ $key ] = $item;
				}
			}
			else {
				if ( !array_key_exists( $key, $listItems ) ) {
					$missingItems[ $key ] = $item;
				}
			}
		}
		return $missingItems;
	}


}
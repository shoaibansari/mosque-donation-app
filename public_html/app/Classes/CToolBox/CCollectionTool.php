<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/27/2016
 * Time: 9:20 PM
 */

namespace App\Classes\CToolBox;

class CCollectionTool {

	/**
	 * @return CCollectionTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CCollectionTool();
		}

		return $instance;
	}

	public function isCollection( $collection ) {
		return (bool)($collection instanceof \Illuminate\Support\Collection);
	}

	public function columnToCsv( $result, $field, $separator = "," ) {
		$tmp = [];
		foreach ($result as $row) {
			$tmp[] = $row->{$field};
		}
		return implode( $separator, $tmp );
	}

	public function getItem( $collection, $field, $returnArray=false ) {
		if ( empty($collection) || !$this->check($collection) || count($collection) == 0) {
			return false;
		}
		foreach ($collection as $row) {
			//
		}

	}


}
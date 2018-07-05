<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 12/1/2016
 * Time: 2:07 AM
 */

namespace App\Classes\CToolBox;

class CNumberTool {

	/**
	 * @return CNumberTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CNumberTool();
		}

		return $instance;
	}

	public static function toHex( $number ) {
		$number = strtoupper( dechex( (float)$number ) );

		return sprintf( "%02s", $number );
	}

	public function toRoman( $number ) {

		// Make sure that we only use the integer portion of the value
		$n = intval( $number );
		$result = '';

		// Declare a lookup array that we will use to traverse the number:
		$lookup = array('M'  => 1000,
		                'CM' => 900,
		                'D'  => 500,
		                'CD' => 400,
		                'C'  => 100,
		                'XC' => 90,
		                'L'  => 50,
		                'XL' => 40,
		                'X'  => 10,
		                'IX' => 9,
		                'V'  => 5,
		                'IV' => 4,
		                'I'  => 1
		);

		foreach ($lookup as $roman => $value) {
			// Determine the number of matches
			$matches = intval( $n / $value );

			// Store that many characters
			$result .= str_repeat( $roman, $matches );

			// Subtract that from the number
			$n = $n % $value;
		}

		// The Roman numeral should be built, return it
		return $result;
	}


}
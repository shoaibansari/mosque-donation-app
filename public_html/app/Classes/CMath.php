<?php
namespace App\Classes;

class CMath {

	public static function roundTo($number, $denominator = 1) {
	    $x = $number * $denominator;
	    $x = floor($x);
	    $x = $x / $denominator;
	    return $x;
	}

	public static function minutesToDecimal($minutes, $round=true) {

		$base = 60;
		$hours = floor($minutes / $base);
		$reminder = $minutes % $base;
		$decimal = 0;
		if  ( $reminder > 0 ) {
			if ( $rem = $reminder % 15 == 0  ) {
				$decimal = $reminder * 100 / $base;
			}
			else {
				if ( $round ) {
					$div = $reminder / 15;
					$ml = ($rem % 15 > 8) ? 0.25 : 0;
					$decimal = round($div) * 25 + $ml;
				}
				else {
					$decimal = $reminder * 100 / $base;
				}
			}
		}
		if ( $decimal == 100 ) {
			$hours++;
			$decimal = 0;
		}
		return floatval($hours . '.' . round($decimal));
	}


}
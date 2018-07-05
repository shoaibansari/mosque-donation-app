<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/26/2016
 * Time: 6:05 AM
 */

namespace App\Classes\CToolBox;

use Illuminate\Support\Facades\DB;

class CStringTool {

	/**
	 * @return CStringTool
	 */
	public static function instance() {
		static $instance;
		if (!$instance) {
			$instance = new CStringTool();
		}

		return $instance;
	}

	/**	 
	 * 
	 * @param $subject
	 * @param array $params
	 * @param array $enclosure
	 * @return mixed
	 */
	public function fillText( $subject, $params=array(), $enclosure=["{", "}"] ) {
		if ( empty($params) ) {
			return $subject;
		}
		$enclosure = (empty($enclosure) || count($enclosure)<2) ? [ "{", "}" ] : $enclosure;

		$params2 = [];
		if ( is_array($params) ) {
			foreach ( $params as $key => $param ) {
				$params2 [ $enclosure[0] . $key . $enclosure[1]] = $param;
			}
		}
		$search = array_keys( $params2 );
		$replaceWith = array_values( $params2 );
		if ( is_array( $subject) ) {
			foreach ($subject as $key => &$item) {
				$item = str_replace( $search, $replaceWith, $item );
			}
			return $subject;
		}
		return str_replace( $search, $replaceWith, $subject);
	}


	/**
	 * Generate password based on pattern
	 * x - Lower case
	 * X - Upper Case
	 * v - lower case vowel
	 * V - Upper case vowel
	 * c - Lower case consonant
	 * C - Upper case consonant
	 * 0 - Digit
	 * * - Special character
	 *
	 * @param string $pattern
	 * @param bool $shuffle
	 * @param string $special_chars
	 * @return string
	 */
	public function pattern( $pattern = "", $shuffle = true, $special_chars = null ) {
		if (empty($pattern)) {
			$pattern = "Xxxxx0*xxx00";
		}

		if (!$special_chars) {
			$special_chars = '~!@#$^&*-=+?;:';
		}

		$pwd = "";
		for ($i = 0; $i < strlen( $pattern ); $i++) {
			$value = substr( $pattern, $i, 1 );
			switch ($value) {
				case 'a':
					if ( rand(1,2) == 1)
						$pwd .= chr( rand( 97, 122 ) );
					else
						$pwd .= chr( rand( 65, 90 ) );
					break;
				case "x": // lower case letter
					$pwd .= chr( rand( 97, 122 ) );
					break;
				case "X": // upper case letter
					$pwd .= chr( rand( 65, 90 ) );
					break;
				case "v": // lower case vowel
					$pwd .= substr( "aeiou", rand( 1, 5 ) - 1, 1 );
					break;
				case "V": // upper case vowel
					$pwd .= substr( "AEIOU", rand( 1, 5 ) - 1, 1 );
					break;
				case "c": // lower case consonant
					$pwd .= substr( "bcdfghjklmnpqrstvwxyz", rand( 1, 21 ) - 1, 1 );
					break;
				case "C": // upper case consonant
					$pwd .= substr( "BCDFGHJKLMNPQRSTVWXYZ", rand( 1, 21 ) - 1, 1 );
					break;
				case "0": // digit
					$pwd .= rand( 1, 10 ) - 1;
					break;
				case "*": // symbol
					$pwd .= substr( $special_chars, rand( 1, strlen( $special_chars ) ) - 1, 1 );
					break;
			}
		}
		if ($shuffle) {
			$pwd = str_shuffle( $pwd );
		}

		return $pwd;
	}

	public function password( $length=12, $characters=true, $numbers=true, $special_chars=true ) {
		$pattern = "";
		$options = [];
		if ( $characters ) $options[] = 'a';
		if ( $numbers ) $options[] = '0';
		if ( $special_chars ) $options[] = '*';
		if ( !$options ) {
			$options = [ 'a', '0', '*'];
		}

		$max = count( $options ) -1;
		for( $i=0; $i< $length; $i++) {
			$pattern .= $options[ rand(0, $max ) ];
		}
		return $this->pattern( $pattern,true );
	}

	/**
	 * Generate unique hash value according to database provided table and field
	 *
	 * @param $table
	 * @param $field
	 * @param int $length
	 * @return null|string
	 * @throws \Exception
	 */
	public function uniqueHash( $table, $field, $length = 30) {

		if ( empty($table) ) {
			throw new \Exception("Table name is required");
		}

		if ( empty( $field ) ) {
			throw new \Exception( "Field name is required" );
		}

		while( true ) {
			$hash = $this->randomHash( $length );
			if ( !DB::table( $table )->where( $field, $hash)->count() ) {
				return $hash;
			}
		}

		return null;
	}

	/**
	 * Get random hash
	 *
	 *
	 * @param int $length
	 * @return string
	 */
	public function randomHash( $length = 30 ) {
		return $this->password( $length, true, true, false );
	}


	/**
	 * Get random character from provided string
	 *
	 * @param $str
	 * @param int $length
	 * @return bool|string
	 */
	public function randomChar( $str, $length = 1 ) {
		$str = str_shuffle( $str );
		if ($length >= strlen( $str )) {
			return $str;
		}

		return substr( $str, 0, $length );
	}
	
	/**
	 * @param $string
	 * @param int $limit
	 * @return string
	 */
	public function limitText( $string, $limit=40 ) {
		if ( !$string || strlen($string) <= $limit ) {
			return $string;
		}
		
		return substr( $string, 0, $limit ) . '...';
	}

}
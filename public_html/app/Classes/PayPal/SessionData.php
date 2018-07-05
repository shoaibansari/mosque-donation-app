<?php
namespace App\Classes\PayPal;

use Illuminate\Support\Facades\Session;

class SessionData {

	const SESSION_KEY = 'PP_NVP_SESSION';

	public function setMethodData( $method, $key, $val ) {
		$data = array();
		if ( Session::has( self::SESSION_KEY ) ) {
			$data = Session::get( self::SESSION_KEY );
		}
		$data[ $method ][ $key ] = $val;
		Session::put( self::SESSION_KEY, $data );
	}

	public function getMethodData( $method, $key = null ) {
		if (!Session::has( self::SESSION_KEY )) {
			return null;
		}
		$data = Session::get( self::SESSION_KEY );
		if (!is_array( $data )) {
			return null;
		}
		$chunk = array_key_exists( $method, $data ) ? $data[ $method ] : null;
		if (is_null( $key )) {
			return $chunk;
		}
		if (!is_array( $chunk )) {
			return null;
		}

		return array_key_exists( $key, $chunk ) ? $chunk[ $key ] : null;
	}

	public function get( $fetch = false ) {
		$data = Session::get( self::SESSION_KEY );
		if ($fetch) {
			$this->clear();
		}
		return $data;
	}

	public function clear() {
		Session::forget( self::SESSION_KEY );
	}
}
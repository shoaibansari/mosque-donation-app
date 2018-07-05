<?php namespace App\Classes\CToolBox;

use App\Models\Repositories\Eloquent\CountryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CIPTool {

	protected $ip;

	/**
	 * @return CIPTool
	 */
	public static function instance( $ip=null ) {
		static $instance;
		if ( !$instance ) {
			$instance = new CIPTool();
		}

		if ( !is_null($ip)) {
			$instance->set( $ip );
		}

		return $instance;
	}

	public function info( $key = null, $default = false ) {

		$ip = $this->get();
		session()->forget( 'user_ip_data' ) ;
		#/ Checking session for IP info
		if ( session()->has( 'user_ip_data' ) ) {
			$data = session()->get( 'user_ip_data' );
			if ( array_key_exists( $ip, $data) ) {
				$ipData = $data[$ip];
				if ( !is_null( $key ) ) {
					return array_key_exists( $key, $ipData ) ? $ipData[ $key ] : $default;
				}
				else {
					return $ipData ? $ipData : $default;
				}
			}
		}

		#/ Getting IP info
		if ( !$country_code = $this->getCountryCodeFromApi( $ip ) ) {
			return $default;
		}

		#/ Getting more info of country, and storing in session
		$country = CountryRepository::instance()->getByCountryCode( $country_code );
		$data[ $ip ] = [
			'ip'             => $ip,
			'countryId'      => $country->id,
			'countryName'    => $country->title,
			'countryCode'    => $country->code,
			'currencyName'   => $country->currency_name,
			'currencyCode'   => $country->currency_code,
			'currencySymbol' => $country->currency_symbol
		];

		#/ Updating session
		session()->put( 'user_ip_data', $data );

		if ( !is_null( $key ) ) {
			$ipData = $data[ $ip ];
			return array_key_exists( $key, $ipData ) ? $ipData[ $key ] : $default;
		}

		return $data;
	}

	public function set( $ip ) {
		$this->ip = $ip;
		return $this;
	}

	public function get() {
		return is_null( $this->ip ) ? request()->getClientIp() : $this->ip;
	}

	public function getCountryId() {
		return $this->info( 'countryId' );
	}

	public function getCountryName( ) {
		return $this->info( 'countryName' );
	}

	public function getCountryCode( ) {
		return $this->info( 'countryCode' );
	}

	public function getCurrencyName() {
		return $this->info( 'currencyName' );
	}

	public function getCurrencyCode() {
		return $this->info( 'currencyCode' );
	}

	public function getCurrencySymbol() {
		return $this->info( 'currencySymbol' );
	}

	private function getCountryCodeFromApi( $ip, $timeout=5 ) {

		#/ Reading IP info
		$context = stream_context_create( ['http' => ['timeout' => $timeout] ] );
		$response = @file_get_contents( 'http://ip2c.org/' . $ip, false, $context );
		if ( !$response ) {
			return false;
		}

		#/ Parsing IP info
		$response = explode( ';', $response );
		if ( isset($response[3]) && $response[3] == 'Reserved' ) {
			return false;
		}

		return $response[1];
	}

}

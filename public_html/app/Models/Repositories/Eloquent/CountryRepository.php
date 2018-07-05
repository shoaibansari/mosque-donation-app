<?php

namespace App\Models\Repositories\Eloquent;

use Datatables;
use Input;
use App\Models\Country;
use App\Models\Repositories\CountryRepositoryInterface;
use Validator;

class CountryRepository extends AbstractRepository implements CountryRepositoryInterface {

	public function __construct( Country $country ) {
		parent::__construct( $country );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return CountryRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$country = new Country( $attributes );
			$instance = new CountryRepository( $country );
		}

		return $instance;
	}

	/**
	 * Get listing
	 *
	 * @param bool $plain
	 * @param bool $array
	 * @return mixed
	 */
	public function getAllActive( $plain=false, $array=false ) {
		if ( $plain ) {
			if ( $array ) {
				return $this->getModel()->select( 'id', 'name' )->active()->get()->toArray();
			}
			else {
				return @json_decode( $this->getModel()->select( 'id', 'name' )->active()->get()->toJson() );
			}
		}
		return $result = $this->getModel()->active()->get();
	}

	/**
	 * Get data for list box
	 *
	 * @return array
	 */
	public function getActiveList() {
		if ( !$data = $this->getAllActive( true ) ) {
			return [];
		}

		$output = [];
		foreach( $data as $item ) {
			$output[ $item->id ] = $item->name;
		}
		return $output;
	}

	public function getByCountryCode( $code ) {
		$country = $this->model->where( 'code', $code )->take( 1 )->first();
		if ( !$country ) {
			return false;
		}
		return $country;
	}

	public function getIdByCountryCode( $code ) {
		$country = $this->getByCountryCode( $code );
		if ( !$country ) {
			return false;
		}

		return $country->id;
	}


}

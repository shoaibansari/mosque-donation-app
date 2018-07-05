<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 12/8/2017 6:03 PM
 */

namespace App\Models\Repositories\Eloquent;

use App\Models\Repositories\DiscriminationEloquentInterface;
use App\Models\Discrimination;

class DiscriminationRepository extends AbstractRepository implements DiscriminationEloquentInterface {

	public function __construct( Discrimination $discrimination ) {
		parent::__construct( $discrimination );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return DiscriminationRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$discrimination = new Discrimination( $attributes );
			$instance = new DiscriminationRepository( $discrimination );
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
	public function getAllActive( $plain = false, $array = false ) {
		if ( $plain ) {
			if ( $array ) {
				return $this->getModel()->select( 'id', 'title' )->active()->get()->toArray();
			}
			else {
				return @json_decode( $this->getModel()->select( 'id', 'title' )->active()->get()->toJson() );
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
		foreach ( $data as $item ) {
			$output[ $item->id ] = $item->title;
		}

		return $output;
	}

	/**
	 * Get all active by country id
	 *
	 * @param int $countryId
	 * @param bool $plain
	 * @param bool $array
	 * @return mixed
	 */
	public function getAllActiveByCountryId( $countryId, $plain = false, $array = false ) {
		if ( $plain ) {
			if ( $array ) {
				return $this->getModel()
					->select( 'id', 'title' )
					->active()
					->where('country_id', $countryId)
					->get()
					->toArray();
			}
			else {
				return @json_decode( $this->getModel()
					                     ->select( 'id', 'title' )
					                     ->active()
					                     ->where( 'country_id', $countryId )
					                     ->get()
					                     ->toJson() );
			}
		}

		return $result = $this->getModel()->where( 'country_id', $countryId )->active()->get();
	}



}
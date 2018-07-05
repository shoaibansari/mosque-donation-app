<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 12/29/2017 4:02 PM
 */

namespace App\Models\Repositories\Eloquent;

use App\Models\Repositories\ViolationRepositoryInterface;
use App\Models\Violation;

class ViolationRepository extends AbstractRepository implements ViolationRepositoryInterface {

	/**
	 * PageRepository constructor.
	 * @param Violation $violation
	 */
	public function __construct( Violation $violation ) {
		parent::__construct( $violation );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return ViolationRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$violation = new Violation( $attributes );
			$instance = new ViolationRepository( $violation );
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

		/*
		if ( !$data = $this->getModel()->select( 'id', 'title' )->active()->get() ) {
			return [];
		}

		$output = [];
		foreach ( $data as $item ) {
			$output[ $item->id ] = $item->title;
		}

		return $output;
		*/

		return $this->getModel()->whereActive(1)->pluck( 'title', 'id' );
	}
	
	/**
	 * Get total violations
	 *
	 * @return int
	 */
	public function getTotal() {
		return $this->getModel()->count();
	}
	
	


}
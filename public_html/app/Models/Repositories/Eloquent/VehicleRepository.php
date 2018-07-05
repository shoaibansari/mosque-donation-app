<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Repositories\VehicleRepositoryInterface;
use App\Models\Vehicle;

class VehicleRepository extends AbstractRepository implements VehicleRepositoryInterface {



	public function __construct( Vehicle $vehicle ) {
		parent::__construct( $vehicle );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return VehicleRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new VehicleRepository( (new Vehicle($attributes)) );
		}

		return $instance;
	}
	
	/**
	 * Get drivers list
	 *
	 * @param int $active
	 * @return mixed
	 */
	public function getVehiclesList($active = 1) {
		if ( $active ) {
			return $this->model->active()->pluck('title', 'id');
		}
		return $this->model->pluck('title', 'id');
	}


}

<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Repositories\VehicleUserRepositoryInterface;
use App\Models\VehicleUser;

class VehicleUserRepository extends AbstractRepository implements VehicleUserRepositoryInterface {

	public function __construct( VehicleUser $vehicleUser ) {
		parent::__construct( $vehicleUser );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return VehicleUserRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new VehicleUserRepository( (new VehicleUser($attributes)) );
		}

		return $instance;
	}

}

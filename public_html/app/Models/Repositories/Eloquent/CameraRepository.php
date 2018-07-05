<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Repositories\CameraRepositoryInterface;
use App\Models\Camera;

class CameraRepository extends AbstractRepository implements CameraRepositoryInterface {
	
	public function __construct(Camera $camera ) {
		parent::__construct( $camera );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return CameraRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new CameraRepository( (new Camera($attributes)) );
		}

		return $instance;
	}
	
	
}

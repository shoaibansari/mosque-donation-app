<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Driver;
use App\Models\Repositories\DriverRepositoryInterface;

class DriverRepository extends AbstractRepository implements DriverRepositoryInterface {
	
	public function __construct( Driver $driver ) {
		parent::__construct($driver );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return DriverRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new DriverRepository( (new Driver($attributes)) );
		}

		return $instance;
	}
	
//	public function addRecord( $user_id ) {
//
//		if( $this->model->whereUserId( $user_id )->count() ) {
//			return true;
//		}
//
//		return $this->model->create( ['user_id' => $user_id ] );
//	}
//
//	public function remove( $user_id ) {
//
//		if(  $driver = $this->model->whereUserId($user_id)->first() ) {
//			return true;
//		}
//
//		try {
//			$driver->delete();
//		} catch ( \Exception $e ) {
//
//			$this->setErrorMessage('Unable to remove driver.');
//			return false;
//		}
//
//		return true;
//
//	}
	

}
<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Repositories\AreaLocationRepositoryInterface;
use App\Models\AreaLocation;

class AreaLocationRepository extends AbstractRepository implements AreaLocationRepositoryInterface {

	public function __construct( AreaLocation $areaLocation ) {
		parent::__construct( $areaLocation );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return AreaLocationRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new AreaLocationRepository( (new AreaLocation($attributes)) );
		}

		return $instance;
	}
	
	public function delete($area_id, $location_id ) {
		
		if(!$areaLocation = $this->model->whereAreaId($area_id)->where('location_id', $location_id)->first()) {
			return false;
		}
		try {
			$areaLocation->delete();
		} catch(\Exception $e) {
			return $this->setErrorMessage('Unable to delete location.');
		}
		
		return $this->setMessage('Location has been deleted');
	}
	
	public function getPreviousLocationId( $area_id, $location_id ) {
		if( !$areaLocation = $this->model->whereAreaId($area_id)->where('location_id', '<', $location_id)->orderBy('location_id', 'desc')
			->take(1)->first() ) {
			return false;
		}
		
		return $areaLocation->location_id;
	}
	
	public function getNextLocationId($area_id, $location_id) {
		if( !$areaLocation = $this->model->whereAreaId($area_id)->where('location_id', '>', $location_id)->orderBy('location_id', 'asc')
			->take(1)->first() ) {
			return false;
		}
		
		return $areaLocation->location_id;
	}
	
	public function getAllLocations( $idsOnly=true ) {
		$model = $this->model;
		if ( $idsOnly ) {
			$model->select('location_id');
		}
		$model->groupBy('location_id');
		if ( !$locations = $model->get() ) {
			return [];
		}
		if($idsOnly) {
			return $locations->pluck('location_id');
		}
		return $locations;
	}


}


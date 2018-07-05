<?php

namespace App\Models\Repositories\Eloquent;
use App\Http\Requests\Backoffice\JobUpdateRequest;
use App\Models\AreaLocation;
use App\Models\DriverJob;
use App\Models\Repositories\AreaRepositoryInterface;
use App\Models\Area;
use App\Models\Job;

class AreaRepository extends AbstractRepository implements AreaRepositoryInterface {



	public function __construct( Area $area ) {
		parent::__construct( $area );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return AreaRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new AreaRepository( (new Area($attributes)) );
		}

		return $instance;
	}


	public function getList( $active=true, $field = 'title', $search = null ) {
		if ( $active )
			$area = $this->getModel()->active();
		else
			$area = $this->getModel();
		
		if ( is_null($search) ) {
			return $area->pluck($field, 'id');
		}
		
		return $area->where($field, 'LIKE', '%'.$search.'%')->pluck($field, 'id');
	}
	
	public function isUnassigned( $area_id ) {
		$unassignedAreas = $this->getUnassignedAreaList( true, null, true );
		if($unassignedAreas && !is_scalar($unassignedAreas)) {
			return $unassignedAreas->contains( $area_id );
		}
		return true;
	}

	public function getUnassignedAreaList( $active=true, $except=null, $idsOnly=false ){

		$job = Job::all();
		if(!is_null($except)) {
			if(is_array($except) || is_object($except)) {
				$job = $job->whereNotIn('id', $job);
			}
			else {
				$job = $job->where('id', '<>', $except);
			}
		}
		$assignedAreaIds = $job->pluck('area_id');
		
		
		$areas = $this->getModel();
		if ( $assignedAreaIds && !is_scalar($assignedAreaIds) ) {
			$areas = $areas->whereNotIn('id', $assignedAreaIds);
		}
		
		if($active) {
			$areas =$areas->active();
		}

		if ( $idsOnly )
			return $areas->pluck('id');
		
		return $areas->pluck( 'title', 'id' );
	}
	
	/**
	 * Check an area has a location or not
	 *
	 * @param $area_id
	 * @param $location_id
	 * @return mixed
	 */
	public function hasLocation($area_id, $location_id) {
		return AreaLocation::whereAreaId($area_id)->whereLocationId($location_id)->count() > 0;
	}




}
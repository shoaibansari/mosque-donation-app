<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Job;
use App\Models\Repositories\JobLocationRepositoryInterface;
use App\Models\JobLocation;
use App\Models\VideoView;

class JobLocationRepository extends AbstractRepository implements JobLocationRepositoryInterface {
	
	public function __construct( JobLocation $jobLocation ) {
		parent::__construct( $jobLocation );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return JobLocationRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new JobLocationRepository( (new JobLocation($attributes)) );
		}

		return $instance;
	}
	
	public function getPreviousLocation($job_id, $location_id) {
		if(!$jobLocation = $this->model->whereJobId($job_id)->where('location_id', '<', $location_id)
			->orderBy('location_id', 'desc')
			->take(1)->first()) {
			return false;
		}
		return $jobLocation;
	}
	
	public function getPreviousLocationId($job_id, $location_id) {
		if ( !$jobLocation = $this->getPreviousLocation($job_id, $location_id) ) {
			return false;
		}
		
		return $jobLocation->location_id;
	}
	
	public function getNextLocation($job_id, $location_id) {
		if(!$jobLocation = $this->model->whereJobId($job_id)->where('location_id', '>', $location_id)
			->orderBy('location_id', 'asc')
			->take(1)->first()) {
			return false;
		}
		
		return $jobLocation;
	}
	
	public function getNextLocationId($job_id, $location_id) {
		if(!$jobLocation = $this->getNextLocation($job_id, $location_id)) {
			return false;
		}
		
		return $jobLocation->location_id;
	}
	
	
	/**
	 * Home Owners not associated with any Area/Homeowners' association
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
	 */
	public function unlinkedLocations( $job_id ) {
		
		if( !$job = Job::find($job_id) ) {
			return [];
		}
		
		$jobLocations = $job->locations->pluck('id');
		return UserLocationRepository::instance()->getModel()->whereNotIn('id', $jobLocations)->approved()->get();
	}
	
	/**
	 * Check a job has location or not
	 *
	 * @param $job_id
	 * @param $location_id
	 * @return mixed
	 */
	public function hasLocation( $job_id, $location_id ) {
		return $this->getModel()->whereJobId($job_id)->whereLocationId($location_id)->count() > 0;
	}
	
}
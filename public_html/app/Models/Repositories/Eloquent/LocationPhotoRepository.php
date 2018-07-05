<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Job;
use App\Models\JobLocation;
use App\Models\Repositories\LocationPhotoRepositoryInterface;
use App\Models\LocationPhoto;

class LocationPhotoRepository extends AbstractRepository implements LocationPhotoRepositoryInterface {

	public function __construct( LocationPhoto $locationPhoto ) {
		parent::__construct( $locationPhoto );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return LocationPhotoRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new LocationPhotoRepository( ( new LocationPhoto( $attributes) ) );
		}

		return $instance;
	}
	
	
	/**
	 * @param $data
	 * @return LocationPhoto|bool
	 */
    public function addPhoto($data) {
    	
    	if ( !$photo = $this->model->create( $data ) ) {
	        return $this->setErrorMessage('Unable to update system with uploaded photo info.');
    	}
    		
        // Updating location's status as completed
        if ( $jobLocation = JobLocation::whereJobId( $data['job_id'] )->whereLocationId( $data['location_id'] )->first() ) {
	        $jobLocation->is_completed = 1;
	        $jobLocation->save();
        }
        
        // If all locations of a job are completed then mark the job status as completed.
	    if ( JobLocation::whereJobId($data[ 'job_id' ])->whereIsCompleted(1)->count() ) {
		    if ( $job = Job::find( $data['job_id']) ) {
                $job->is_completed = 1;
                $job->save();
		    }
	    }
	    
	    return $photo;
    }
	
	/**
	 * Get location photo
	 *
	 * @param $location_photo_id
	 * @return bool|mixed
	 */
	public function getPhoto( $location_photo_id ) {
		if( !$locationPhoto = $this->findById($location_photo_id) ) {
			return false;
		}
		return $locationPhoto;
	}
	
	/**
	 * Get first location photo
	 *
	 * @param $location_id
	 * @param null $job_id
	 * @return bool|LocationPhoto
	 */
	public function getFirstPhoto( $location_id, $job_id = null ) {
		$model = $this->getModel()->where('location_id', $location_id);
		if( !is_null($job_id) ) {
			$model = $model->where('job_id', $job_id);
		}
		if(!$locationPhoto = $model->first()) {
			return false;
		}
		return $locationPhoto;
	}
	
	/**
	 * Get next location photo
	 *
	 * @param $location_photo_id
	 * @return LocationPhoto|bool
	 */
	public function getNextPhoto( $location_photo_id ) {
		return $this->_findLocationPhoto( $location_photo_id, '>');
	}
	
	/**
	 * Get prev location photo
	 *
	 * @param $location_photo_id
	 * @return LocationPhoto|bool
	 */
	public function getPrevPhoto( $location_photo_id ) {
		return $this->_findLocationPhoto($location_photo_id, '<');
	}
	
	/**
	 * @param $location_photo_id
	 * @param null $operator
	 * @return bool|LocationPhoto
	 */
	public function _findLocationPhoto( $location_photo_id, $operator = null) {
		
		if( !$locationPhoto = $this->findById($location_photo_id) ) {
			return $this->setErrorMessage('Unable to find location photo.');
		}
		
		$model = $this->getModel()
			->where('location_id', $locationPhoto->location_id )
			->where('job_id', $locationPhoto->job_id);
		
		if( is_null($operator) && $operator == '=') {
			$model = $model->where('id', $location_photo_id);
		}
		else {
			if ( $operator == '<' ) {
				$model = $model->orderBy('id', 'desc');
			}
			$model = $model->where('id', $operator, $location_photo_id);
		}
		
		if(!$locationPhoto = $model->first()) {
			return $this->setErrorMessage('Unable to find photo.');
		}
		
		//toolbox()->dump_query();
		
		return $locationPhoto;
	}
	
	
	/**
	 * Find previous JobLocation by LocationPhotoId
	 *
	 * @param $locationPhotoId
	 * @return bool|JobLocation
	 */
    public function getPrevLocationById( $locationPhotoId ) {
	    return $this->_findJobLocationById( $locationPhotoId, '<' );
    }
	
	/**
	 * Find previous JobLocation by LocationPhotoId
	 *
	 * @param $locationPhotoId
	 * @return bool|JobLocation
	 */
	public function getNextLocationById( $locationPhotoId ) {
		return $this->_findJobLocationById($locationPhotoId, '>');
	}
	
	/**
	 * @param $locationPhotoId
	 * @param $operator
	 * @return bool|JobLocation
	 */
	private function _findJobLocationById( $locationPhotoId, $operator ) {
		
		if(!$locationPhoto = $this->findById($locationPhotoId)) {
			return $this->setErrorMessage('Unable to find current location.');
		}
		
		$jobLocation = $locationPhoto->job->locations()
			->wherePivot('is_completed', 1)
			->where('job_locations.location_id', $operator, $locationPhoto->location->id)
			->first();
		
		if(!$jobLocation) {
			return $this->setErrorMessage('No completed location available at the moment.');
		}
		
		return $jobLocation;
	}
	
	

}
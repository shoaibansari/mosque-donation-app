<?php

namespace App\Models\Repositories\Eloquent;

use App\Models\DriverJob;
use App\Models\JobLocation;
use App\Models\LocationPhoto;
use App\Models\Repositories\JobRepositoryInterface;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class JobRepository extends AbstractRepository implements JobRepositoryInterface {

	const APP_ITEMS_PER_PAGE = 50;

	/**
	 * JobRepository constructor.
	 * @param Job $job
	 */
	public function __construct(Job $job) {
		parent::__construct($job);
	}
	
	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return JobRepository
	 */
	public static function instance($new = false, $attributes = []) {
		static $instance = null;
		if(is_null($instance) || $new) {
			$instance = new JobRepository((new Job($attributes)));
		}
		
		return $instance;
	}
	
	
	/**
	 * @param $data
	 * @param null $driver_id
	 * @return bool|mixed
	 * @throws \Exception
	 */
	public function create( $data, $driver_id=null ) {
		
		// adding job
		if(!$job = $this->addRecord($data)) {
			return $this->setErrorMessage('Unable to create a drive.');
		}
		
		// copying/duplicating locations from area to job details
		$locations = repo()->area()->getModel($data[ 'area_id' ])->locations()->get();
		foreach($locations as $key => $location) {
			repo()->jobLocations()->addRecord(['job_id' => $job->id, 'location_id' => $location->id ]);
		}
		
		// associating/disassociating driver
		if( $driver_id ) {
			
			// Job request send time to the drive.
			$job->requested_at = Carbon::now();
			$job->save();
			
			$this->acceptJob( $job->id, $driver_id );
		}
		
		repo()->activity()->action('create')->item('drive', $job->id, $job->name)->add();
		
		$this->setMessage('The drive has been created.');
		return $job;
	}
	
	/**
	 * @param $jobId
	 * @param $data
	 * @param null $driver_id
	 * @return bool|JobLocation
	 * @throws \Exception
	 */
	public function update($jobId, $data, $driver_id=null) {
		
		if(!$job = $this->findById($jobId)) {
			return $this->setErrorMessage('Unable to find requested drive.');
		}
		
		$data = array_except($data, ['_token']);
		
		$job->update($data);
		
		// removing previously assigned locations to job
		$job->locations()->sync([]);
		
		// copying locations from area to job details
		$locations = repo()->area()->getModel($data[ 'area_id' ])->locations()->get();
		foreach($locations as $key => $location) {
			repo()->jobLocations()->addRecord(['job_id' => $job->id, 'location_id' => $location->id]);
		}
		
		// associating/disassociating driver
		if( $driver_id ) {
			
			// Job request send time to the drive.
			$job->requested_at = Carbon::now();
			$job->save();

			if ( !$this->acceptJob( $job->id, $driver_id) ) {
				return false;
			}
		}
		else {
			
			if ( $job->drivers()->count() ) {
				if(!$this->rejectJob($job->id, $driver_id)) {
					return false;
				}
			}
		}
		
		repo()->activity()->action('update')->item('drive', $job->id, $job->name)->add();
		
		$this->setMessage('The drive has been updated.');
		
		return $job;
	}
	
	/**
	 * Delete a drive/job
	 *
	 * @param $jobId
	 * @return bool
	 * @throws \Exception
	 */
	public function delete($jobId) {
		
		if(!$job = $this->getModel($jobId)) {
			return $this->setErrorMessage('Unable to find requested record.');
		}
		
		try {
			
			// removing job details
			$job->locations()->sync([]);
			
			// unlinking photo from current job.
			foreach( $job->photos as $photo) {
				$photo->job_id = null;
				$photo->save();
			}
			
			// removing job
			$job->delete();
			
		} catch(QueryException $e) {
			\Log::error( $e->getMessage() );
			return $this->setErrorMessage('To delete a drive, you must have to delete the associated records.');
		}
		
		repo()->activity()->action('delete')->item('drive', $job->id, $job->name)->add();
		
		return $this->setMessage('Drive has been deleted.');
	}
	
	/**
	 * @param $job_id
	 * @param $location_id
	 * @param null $user
	 * @return bool|LocationPhoto
	 */
	public function getLocationPhotos($job_id, $location_id, $user = null ) {
		
		if( !$job = $this->getModel($job_id) ) {
			return $this->setErrorMessage('Unable to find drive.');
		}
		
		if ( !is_null($user) && !$job->hasAccess( $user ) ) {
			return $this->setErrorMessage('You can\'t access this drive.');
		}
		
		return $job->photos()->whereLocationId($location_id)->get();
		
	}
	
	/**
	 * Accept job
	 *
	 * @param $job_id
	 * @param $driver_id
	 * @return bool
	 * @throws \Exception
	 */
	public function acceptJob( $job_id, $driver_id ) {
		
		if(!$job = $this->getModel($job_id)) {
			return $this->setErrorMessage('Unable to find drive.');
		}
		
		if(!$driver = repo()->driver()->findById( $driver_id ) ) {
			return $this->setErrorMessage('Unable to find driver.');
		}
		
		// As per the client, the job automatically be set as accepted by the driver.
		// And the driver can reject the job.
		$job->is_accepted = 1;
		$job->accepted_at = Carbon::now();
		
		if(!$job->requestd_at) {
			$job->self_allocate = 1;
		}
		
		// updating job
		$job->save();
		
		// associating job with the driver
		$job->drivers()->sync([ $driver->id ]);
		
		repo()->activity()
			->actor( $driver->id )
			->action('accept', 'accepted a')
			->item('drive', $job->id, $job->name)
			->add();
		
		return $this->setMessage('The job is successfully allocated.');
	}
	
	/**
	 *
	 * @param $job_id
	 * @param $driver_id
	 * @return bool
	 * @throws \Exception
	 */
	public function rejectJob($job_id, $driver_id) {
		
		if(!$job = $this->getModel($job_id)) {
			return $this->setErrorMessage('Unable to find drive.');
		}
		
		if ( $driver_id ) {
			if(!$driver = repo()->driver()->findById($driver_id)) {
				return $this->setErrorMessage('Unable to find driver.');
			}
		}
		
		$job->drivers()->sync([]);
		
		$job->accepted_at = null;
		$job->is_accepted = 0;
		$job->self_allocate = 0;
		$job->requested_at = null;
		$job->save();
		
		repo()->activity()
			->action('reject', 'rejected a')
			->item('drive', $job->id, $job->name)
			->add();
		
		return $this->setMessage('The job set as rejected.');
	}
	
	/**
	 *
	 *
	 * @param $job_id
	 * @param null $driver_id
	 * @return bool
	 * @throws \Exception
	 */
	public function markCompleted($job_id, $driver_id=null) {
		
		if(!$job = $this->getModel($job_id)) {
			return $this->setErrorMessage('Unable to find drive.');
		}
		
		if ( !is_null($driver_id) ) {
			if(!$driver = repo()->driver()->findById($driver_id)) {
				return $this->setErrorMessage('Unable to find driver.');
			}
		}
		
		if ( $job->is_completed ) {
			return $this->setErrorMessage('The drive is already marked as completed.');
		}
		
		$job->is_completed = true;
		if ( $job->locations()->where('is_completed', 0)->count() == 0) {
			$job->is_forcefully_completed = false;
		}
		else {
			$job->is_forcefully_completed = true;
		}
		
		$job->completed_at = Carbon::now();
		$job->save();
		
		repo()->activity()
			->action('complete', 'completed a')
			->item('drive', $job->id, $job->name)
			->add();
		
		return $this->setMessage('The drive has been marked as completed.');
	}
	
	public function getBacklogJobsForAdminDashboard( $limit = 5, $countOnly=false) {
		$model = $this->model->where('is_completed', 0);
		if ( $countOnly ) {
			return $model->count();
		}
		
		return $model->orderBy('name', 'desc')->take( $limit )->get();
	}
	
	public function getUnassignedJobsForAdminDashboard($limit = 5, $countOnly = false) {
		$model = $this->model->where(function($query) {
			$query->where('is_accepted', 0)->orWhereNull('is_accepted');
		});
		
		if($countOnly) {
			return $model->count();
		}
		
		return $model->orderBy('name', 'desc')->take($limit)->get();
	}
	
	public function getCompletedJobsForAdminDashboard($limit = 5, $countOnly = false) {
		$model = $this->model->where('is_completed', 1);
		if($countOnly) {
			return $model->count();
		}
		
		return $model->orderBy('name', 'desc')->take($limit)->get();
	}

	public function getStatistics( $userId ) {
		return [
			'backlog' => $this->getBacklogJobsForAdminDashboard( null, true),
			'unassigned' => $this->getUnassignedJobsForAdminDashboard(null, true),
			'completed' => $this->getCompletedJobsForAdminDashboard( null, true),
			'myDrives' => DriverJob::where('driver_id', $userId)->count()
		];
	}
	
	/**
	 * @param $pageNumber
	 * @param $recordsPerPage
	 * @param $orderBy
	 * @param $order
	 * @return array
	 */
	public function getPaginatedData( $model, $pageNumber, $recordsPerPage=null, $orderBy='created_at', $order='desc'  ) {
		
		//$model = $this->model;
		$recordsPerPage = is_null($recordsPerPage) ? self::APP_ITEMS_PER_PAGE : $recordsPerPage;
		
		if(!$result['totalRecords'] = $model->count()) {
			return [];
		}
		
		// pagination
		if($pageNumber != 'all' && $pageNumber > 0) {
			$offset = ($pageNumber - 1) * $recordsPerPage;
			$model = $model->skip($offset)->take($recordsPerPage);
			$result['paginationInfo'] = $pageNumber . '-' . $offset . ' / ' . $result['totalRecords'];
		}
		else {
			$result['paginationInfo'] = '1 - ' . $result['count'];
		}
		
		$result['records'] = $model->orderBy($orderBy, $order)->get();
		
		return $result;
	}
	
}
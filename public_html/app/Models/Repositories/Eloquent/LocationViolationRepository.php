<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Repositories\LocationViolationRepositoryInterface;
use App\Models\LocationViolation;
use App\Models\ViolationStatus;

class LocationViolationRepository extends AbstractRepository implements LocationViolationRepositoryInterface {

	public function __construct( LocationViolation $locationViolation ) {
		parent::__construct( $locationViolation );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return LocationViolationRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new LocationViolationRepository( (new LocationViolation( $attributes )) );
		}

		return $instance;
	}
	
	
	public function getLocationViolations( $location_id, $returnIds=false, $unique=true ) {
		
		$violations = $this->model->whereLocationId($location_id)
			->join('violations', 'location_violations.violation_id', '=', 'violations.id');
		
		if ( $unique ) {
			$violations->groupBy('violation_id');
		}
		
		if ( !$violations = $violations->get() ) {
			return false;
		}
		
		if ( $returnIds ) {
			return $violations->implode('violation_id', ',');
		}
		
		return $violations;
	}
	
	/**
	 * Report violation on location photo
	 *
	 * @param $reporterId
	 * @param $locationPhotoId
	 * @param $violations
	 * @param $comments
	 * @param $base64_file_contents
	 * @return bool
	 * @throws \Exception
	 */
	public function report($reporterId, $locationPhotoId, $violations, $comments, $base64_file_contents) {
		
		if(!$photo = repo()->locationPhoto()->findById($locationPhotoId)) {
			return $this->setErrorMessage('Unable to find location photo.');
		}
		
		// creating duplicate file name by adding a suffix
		$filename = toolbox()->file()->addSuffix($photo->getImagePath(), '-reported');
		
		if ( is_array($violations) ) {
			foreach($violations as $violationId) {
				
				if(!$violationId) {
					continue;
				}
				
				// If violation already reported to location photo then skipping
				if ( $this->isViolationExist($photo->location_id, $locationPhotoId, $violationId) ) {
					continue;
				}
				
				$locationViolation = $this->addRecord(
					[
						'location_id'  => $photo->location_id,
						'photo_id'     => $locationPhotoId,
						'reporter_id'  => $reporterId,
						'status_id'    => ViolationStatus::TYPE_WARNING,
						'marked_photo' => basename($filename),
						'violation_id' => $violationId,
						'is_completed' => 1
					]
				);
				
				repo()->discussionBoard()->addRecord(
					[
						'comments'              => $comments ? $comments : 'No comments are provided',
						'is_read'               => 0,
						'sender_id'             => $reporterId,
						'receiver_id'           => $photo->location->homeOwner->id,
						'location_violation_id' => $locationViolation->id
					]
				);
				
			}
		}
		
		// decoding base64 image
		toolbox()->image()->createFileFromBase64($filename, $base64_file_contents);
		
		repo()->activity()
				->action('report violation', 'reported violations on')
				->item ( 'location_violation', $photo->location->id, $photo->location->address, 'address' )
				->add();
		
		return $this->setMessage('Violation has been marked.');
	}
	
	public function isViolationExist( $location_id, $location_photo_id, $violation_id ) {
		return $this->model->where('location_id', $location_id)
			->where('photo_id', $location_photo_id)
			->where('violation_id', $violation_id)
			->count();
	}
}
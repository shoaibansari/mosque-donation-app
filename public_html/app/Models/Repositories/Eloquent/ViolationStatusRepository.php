<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 12/29/2017 4:02 PM
 */

namespace App\Models\Repositories\Eloquent;

use App\Models\Repositories\ViolationRepositoryInterface;
use App\Models\Repositories\ViolationStatusRepositoryInterface;
use App\Models\Violation;
use App\Models\ViolationStatus;

class ViolationStatusRepository extends AbstractRepository implements ViolationStatusRepositoryInterface {

	/**
	 * PageRepository constructor.
	 * @param ViolationStatus $violationStatus
	 */
	public function __construct( ViolationStatus $violationStatus ) {
		parent::__construct( $violationStatus );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return ViolationStatusRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new ViolationStatusRepository( (new ViolationStatus($attributes) ) );
		}

		return $instance;
	}
	
	public function getList($active = true, $field = 'title', $search = null) {
		if($active) {
			$area = $this->getModel()->active();
		}
		else {
			$area = $this->getModel();
		}
		
		if(is_null($search)) {
			return $area->pluck($field, 'id');
		}
		
		return $area->where($field, 'LIKE', '%'.$search.'%')->pluck($field, 'id');
	}
	

}
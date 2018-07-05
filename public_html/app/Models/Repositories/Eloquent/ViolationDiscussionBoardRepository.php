<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Repositories\ViolationDiscussionBoardRepositoryInterface;
use App\Models\ViolationDiscussionBoard;

class ViolationDiscussionBoardRepository extends AbstractRepository implements ViolationDiscussionBoardRepositoryInterface {

	public function __construct( ViolationDiscussionBoard $violationDiscussionBoard ) {
		parent::__construct( $violationDiscussionBoard );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return ViolationDiscussionBoardRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new ViolationDiscussionBoardRepository( (new ViolationDiscussionBoard($attributes))  );
		}

		return $instance;
	}

}
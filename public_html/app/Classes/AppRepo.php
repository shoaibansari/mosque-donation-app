<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 12/6/2017 12:04 AM
 */

namespace App\Classes;

use App\Models\Repositories\Eloquent\ActivityRepository;
use App\Models\Repositories\Eloquent\AreaRepository;
use App\Models\Repositories\Eloquent\DriverRepository;
use App\Models\Repositories\Eloquent\JobLocationRepository;
use App\Models\Repositories\Eloquent\JobRepository;
use App\Models\Repositories\Eloquent\LocationPhotoRepository;
use App\Models\Repositories\Eloquent\LocationViolationRepository;
use App\Models\Repositories\Eloquent\MenuRepository;
use App\Models\Repositories\Eloquent\PageRepository;
use App\Models\Repositories\Eloquent\UserLocationRepository;
use App\Models\Repositories\Eloquent\UserRepository;
use App\Models\Repositories\Eloquent\VehicleUserRepository;
use App\Models\Repositories\Eloquent\VideoRepository;
use App\Models\Repositories\Eloquent\ViolationDiscussionBoardRepository;

class AppRepo {

	/**
	 * @return AppRepo
	 */
	public static function instance() {
		static $instance;
		if ( !$instance ) {
			$instance = new AppRepo();
		}

		return $instance;
	}

	/**
	 * @return MenuRepository
	 */
	public function menu() {
		return MenuRepository::instance();
	}

	/**
	 * @return PageRepository
	 */
	public function page() {
		return PageRepository::instance();
	}

	/**
	 * @return UserRepository
	 */
	public function user() {
		return UserRepository::instance();
	}
	
	/**
	 * @return DriverRepository
	 */
	public function driver() {
		return DriverRepository::instance();
	}

	/**
	 * @return UserLocationRepository
	 */
	public function userLocations() {
		return UserLocationRepository::instance();
	}

	/**
	 * @return VehicleUserRepository
	 */
	public function userVehicles() {
		return VehicleUserRepository::instance();
	}

	/**
	 * @return AreaRepository
	 */
	public function area() {
		return AreaRepository::instance();
	}

	/**
	 * @return JobRepository
	 */
	public function job() {
		return JobRepository::instance();
	}

	/**
	 * @return JobLocationRepository
	 */
	public function jobLocations() {
		return JobLocationRepository::instance();
	}
	
	/**
	 * @return LocationPhotoRepository
	 */
	public function locationPhoto() {
		return LocationPhotoRepository::instance();
	}
	
	/**
	 * @return LocationViolationRepository
	 */
	public function locationViolation() {
		return LocationViolationRepository::instance();
	}
	
	/**
	 * @return ViolationDiscussionBoardRepository
	 */
	public function discussionBoard() {
		return ViolationDiscussionBoardRepository::instance();
	}
	
	/**
	 * @return ActivityRepository
	 */
	public function activity() {
		return ActivityRepository::instance();
	}
	




}
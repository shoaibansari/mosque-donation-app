<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\AreaLocation;
use App\Models\Area;
use App\Models\Job;
use App\Models\Repositories\UserDeviceRepositoryInterface;
use App\Models\User;
use App\Models\UserDevice;
use Carbon\Carbon;

class UserDeviceRepository extends AbstractRepository implements UserDeviceRepositoryInterface {

	
	public function __construct( UserDevice $userDevice ) {
		parent::__construct( $userDevice );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return UserDeviceRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new UserDeviceRepository( (new UserDevice($attributes)) );
		}

		return $instance;
	}
	
	public function findDeviceByToken($token) {
		if(!$device = $this->model->whereToken($token)->first()) {
			return false;
		}
		
		return $device;
	}
	
	public function findUserByToken($token ) {
		if ( !$device = $this->model->whereToken($token)->first() ) {
			return false;
		}
		
		$user = $device->user;
		unset( $device->user, $device->user_id, $device->token, $device->device_id, $device->id, $device->created_at, $device->updated_at );
		$user->device = $device;
		$user->avatar = $user->getAvatarUrl();
		return $user;
	}

	
	/**
	 * Add or update user device and returns a auth_token
	 *
	 * @param $device_id
	 * @param $user_id
	 * @param $data
	 * @return bool|string
	 */
	public function addOrUpdate( $device_id, $user_id, $data ) {
		
		if ( !$user = User::find( $user_id ) ) {
			return $this->setErrorMessage('Invalid user-id');
		}
		
		$token = $this->generateToken($user->id, $user->email, $device_id);
		if ( !$device = $this->model->whereDeviceId( $device_id )->first() ) {
			$device = new UserDevice();
			$device->device_id = $device_id;
		}
		
		$device->user_id = $user->id;
		$device->token = $token;
		$device->platform = isset($data['platform']) ? $data['platform'] : '';
		$device->os_version = isset($data['os_version']) ? $data['os_version'] : '';
		$device->gcm_id = isset($data['gcm_id']) ? $data['gcm_id'] : '';
		$device->notifications = isset($data['notifications']) ? $data['notifications'] : '';
		$device->badges = isset($data['badges']) ? $data['badges'] : '';
		$device->latitude = isset($data['latitude']) ? $data['latitude'] : '';
		$device->longitude = isset($data['longitude']) ? $data['longitude'] : '';
		$device->last_activity_at = Carbon::now();
		
		$device->save();
		
		return $token;
	}
	
	/**
	 * Remove token from user specified device.
	 *
	 * @param $token
	 * @return bool
	 */
	public function removeToken( $token ) {
		$device = $this->findDeviceByToken( $token );
		$device->token = '';
		$device->save();
		return true;
	}
	
	/**
	 * Generate auth_token
	 *
	 * @param $user_id
	 * @param $email
	 * @param $device_id
	 * @return string
	 */
	public function generateToken( $user_id, $email, $device_id ) {
		$token = null;
		while( true ) {
			$token = sha1(str_shuffle($user_id . $email . $device_id . time()));
			if ( $this->model->whereToken( $token )->count() == 0) {
				break;
			}
		}
		
		return $token;
	}

}

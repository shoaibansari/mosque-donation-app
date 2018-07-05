<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 12/18/2017 12:47 PM
 */

namespace App\Models\Repositories\Eloquent;

use App\Models\AreaLocation;
use App\Models\Repositories\UserLocationEloquentInterface;
use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Database\QueryException;

class UserLocationRepository extends AbstractRepository implements UserLocationEloquentInterface {


	/**
	 *
	 * UserLocationRepository constructor.
	 * @param UserLocation $userLocation
	 */
	public function __construct( UserLocation $userLocation ) {
		parent::__construct( $userLocation );
	}


	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return UserLocationRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$userLocation = new UserLocation( $attributes );
			$instance = new UserLocationRepository( $userLocation );
		}

		return $instance;
	}


	/**
	 * Accept or reject a location
	 *
	 * @param $locationId
	 * @param $status
	 * @return bool
	 */
	public function status( $locationId, $status ) {

		if ( !$location = $this->findById( $locationId ) ) {
			return $this->setErrorMessage( 'Unable to find requested location.' );
		}

		$location->is_approved = !$status ? 0 : 1;
		$location->save();

		$this->setMessage( 'The location has been ' . ($status ? 'approved.' : 'rejected.') );
		return $location;
	}
	
	/**
	 * Get locations in pending stat
	 *
	 * @param null $user_id
	 * @return mixed
	 */
	public function getPendingLocationsCount( $user_id=null ) {
		
		$ul = UserLocation::join('users', 'user_locations.homeowner_id', '=', 'users.id')
			->pending()
			->confirmationStatus(1);
		
		if ( !is_null($user_id) ) {
			$ul->where('users.id', $user_id);
		}
		
		return $ul->count();
		
	}
	
	/**
	 * Delete location
	 *
	 * @param $userLocationId
	 * @return bool
	 */
	public function delete( $userLocationId, $user_id=null ) {
		
		if ( !is_null($user_id) ) {
			$user = $this->getModel( $user_id );
			
			$ul = $user->locations()->whereId( $userLocationId )->first();
			if ( $user->isHomeOwner() && $ul->isApproved() ) {
				return $this->setErrorMessage('You can\'t delete a location which is approved by the admin.');
			}
		}
		else {
			$ul = $this->findById($userLocationId);
		}
		
		if ( !$ul ) {
			return $this->setErrorMessage( 'User location not found.' );
		}

		$ul->delete();

		return $this->setMessage( 'User location has been deleted.' );
	}

	/**
	 * Find location by address
	 *
	 * @param $address
	 * @return bool|\Illuminate\Database\Eloquent\Model|null|static
	 */
	public function findByAddress( $address ) {
		if ( !$location = $this->getModel()->where( 'address', $address )->first() ) {
			return $this->setErrorMessage( 'Address not found.' );
		}

		return $location;
	}
	
	/**
	 * Home Owners not associated with any Area/Homeowners' association
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
	 */
	public function unlinkedLocations() {
		$areaLocations = AreaLocationRepository::instance()->getAllLocations();
		return $this->getModel()->whereNotIn('id', $areaLocations)->approved()->get();
	}
	
	/**
	 * Get homeowners list
	 *
	 * @param int $approved
	 * @param string $field
	 * @param string $search
	 * @return array
	 */
	public function getLocationsList($approved = 1, $field = 'address', $search = null) {
		
		$locations = $this->getModel()->whereHas('homeOwner', function($query) {
			//$query->active();
			$query->confirmed();
		});
		
		if($approved) {
			$locations->approved();
		}
		if( !is_null($search) ) {
			$locations->where($field, 'LIKE', '%' . $search . '%');
		}
		
		
		return $locations->orderBy('address')->groupBy('address')->get()->pluck($field, 'id');
	}


}
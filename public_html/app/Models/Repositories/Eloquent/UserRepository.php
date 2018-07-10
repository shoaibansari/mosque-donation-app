<?php
namespace App\Models\Repositories\Eloquent;

use App\Models\Driver;
use App\Models\Mosque;
use App\Models\Permission;
use App\Models\Repositories\UserRepositoryInterface;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserMosque;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

	protected $user, $avatarStoragePath;

	/**
	 * UserRepository constructor.
	 * @param User $users
	 */
    public function __construct( User $users ) {
    	parent::__construct( $users );
        $this->model   = $users;
	    $this->avatarStoragePath = $this->getModel()->getAvatarStoragePath();
    }

    /**
	* Get current logged-in user
	*
	* @return User|null
	*/
	public function getLoggedInUser() {
		
		if(auth('admin')->check()) {
			return auth('admin')->user();
		}

		if(request()->is('api/*') && $token = request('token')) {
			return UserDeviceRepository::instance()->findUserByToken($token);
		}

		return auth()->user();
	}


    public function changeStatus( $user_id, $status ) {
    	if ( !$user = $this->getModel( $user_id ) ) {
    		return $this->setErrorMessage( 'User does not exist.');
	    }

	    $user->is_blocked = $status ? 1 : 0;
	    $user->save();

	    return $this->setMessage( 'User status has been changed.' );
    }

	/**
	 * Get repo instance
	 *
	 * @param bool $new
	 * @param array $attributes
	 * @return UserRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$user = new User( $attributes );
			$instance = new UserRepository( $user );
		}

		return $instance;
	}

	/**
	 * Find user by email address
	 *
	 * @param $email
	 * @return bool|\Illuminate\Database\Eloquent\Model|null|static
	 */
	public function findByEmailAddress( $email ) {
		if ( !$user = $this->getModel()->where( 'email', $email )->first() ) {
			return $this->setErrorMessage( 'User not found.' );
		}

		return $user;
	}

	/**
	 * Find user by confirmation code.
	 *
	 * @param $code
	 * @return bool|\Illuminate\Database\Eloquent\Model|null|static
	 */
	public function findByConfirmationCode( $code ) {
		if ( !$user = $this->getModel()->where( 'confirmation_code', $code )->first() ) {
			return $this->setErrorMessage( 'The confirmation code is no longer valid.' );
		}

		return $user;
	}

	/**
	 * Create
	 *
	 * @param $data
	 * @param null $avatar
	 * @return bool|mixed
	 */
	public function create( $data, $avatar = null ) {
		return $this->add( $data, $avatar );
	}

	/**
	 * Register "Home Owener" user
	 *
	 * @param $data
	 * @return bool|mixed
	 */
	public function register( $data ) {

		$data[ 'is_administrative_user' ] = 0;  // Not an administrative user
		$data[ 'is_confirmed' ] = 0;
		if ( !$user = $this->add( $data ) ) {
			return false;
		}

		// Adding user location, that will further require APPROVAL from the admin.
//        if ( isset($data['street']) ){
//            $location = new UserLocation();
//            $location->street = $data[ 'street' ];
//            $location->city = $data[ 'city' ];
//            $location->state = $data[ 'state' ];
//            $location->zip = $data[ 'zip' ];
//            $location->homeowner_id = $user->id;
//            $location->latitude = $data['latitude'];
//            $location->longitude = $data['longitude'];
//            $location->address = implode(" ", [ $location->street, $location->city, $location->state, $location->zip ]);
//            $location->save();
//		}

		return $user;
	}


	/**
	 * Update
	 *
	 * @param $user_id
	 * @param $data
	 * @param null $avatar
	 * @return bool|mixed
	 */
	public function update( $user_id, $data, $avatar=null ) {
		if ( !$user = $this->findById( $user_id ) ) {
			return $this->setErrorMessage( 'Requested user is not available.' );
		}

		if ( isset( $data[ 'password' ] ) && strlen( $data[ 'password' ] ) > 0 ) {
			$data[ 'password' ] = bcrypt( $data[ 'password' ] );
		}

		// updating record
		$user->update( $data );

		if ( $avatar ) {
			$oldAvatar = $this->avatarStoragePath . '/' . $user->avatar;
			$ext = $avatar->getClientOriginalExtension();
			$avatarFilename = $user->id . '-' . Carbon::now()->timestamp . '.' . $ext;
			$newAvatar = $this->avatarStoragePath . '/' . $avatarFilename;
			$avatar->move( $this->avatarStoragePath . '/', $avatarFilename);  
			//Image::make( $avatar->getRealPath() )->fit( 48, 48 )->save( $newAvatar );
			$user->avatar = $avatarFilename;
			$user->save();

			// Removing old avatar
			@unlink( $oldAvatar );
		}

		$this->setMessage( $user->name . ' has been updated.');

		return $user;
	}


    /**
     * Update
     *
     * @param $user_id
     * @param $data
     * @param null token
     * @return bool|mixed
     */
    public function updateUserProfile( $user_id, $data) {

        if ( !$user = $this->findById( $user_id ) ) {
            return $this->setErrorMessage( 'Requested user is not available.' );
        }


        if ( isset( $data[ 'password' ] ) && strlen( $data[ 'password' ] ) > 0 ) {
            $data[ 'password' ] = bcrypt( $data[ 'password' ] );
        }

        // updating record
        $user->update( $data );




//        // storing avatar
//        if ( $avatar ) {
//            $oldAvatar = $this->avatarStoragePath . '/' . $user->avatar;
//            $ext = $avatar->getClientOriginalExtension();
//            $avatarFilename = $user->id . '-' . Carbon::now()->timestamp . '.' . $ext;
//            $newAvatar = $this->avatarStoragePath . '/' . $avatarFilename;
//            Image::make( $avatar->getRealPath() )->fit( 48, 48 )->save( $newAvatar );
//            $user->avatar = $avatarFilename;
//            $user->save();
//
//            // Removing old avatar
//            @unlink( $oldAvatar );
//        }

//        $this->setMessage( $user->name . ' has been updated.');

        //return $user;
    }

	/**
	 * Confirm user by confirmation code
	 *
	 * @param $confirmationCode
	 * @return bool
	 */
	public function confirmByCode( $confirmationCode ) {

		if ( empty( $confirmationCode ) ) {
			return $this->setErrorMessage( 'Confirmation code is missing.' );
		}

		if ( !$user = $this->findByConfirmationCode( $confirmationCode ) ) {
			return false;
		}

		return $this->confirmById( $user->id );
	}

	/**
	 * Confirm user by user-id
	 *
	 * @param $userId
	 * @return bool
	 */
	public function confirmById( $userId ) {

		if ( !$user = $this->getModel($userId) ) {
			return $this->setErrorMessage( 'User does not found.' );
		}

		$user->is_confirmed = 1;
		$user->confirmation_code = '';
		$user->confirmed_at = Carbon::now();
		$user->save();


		return $this->setMessage( 'The user bas been confirmed.' );
	}
	
	public function sendLocationApprovalRequestToAdmin($location ) {
		
		if ( !$location = UserLocationRepository::instance()->getModel( $location ) ) {
			return false;
		}
		
		toolbox()
			->email()
			->toAdmin()
			->subject('Request for Location Approval')
			->message(
				toolbox()->frontend()->view('emails.location-approval'), [
				'name'         => $location->homeOwner->name,
				'location'     => array_only($location->toArray(), ['street', 'city', 'zip', 'state', 'country']),
				'approvalLink' => route('admin.users.locations.review', $location->id)
			])
			->send();
		
		return true;
	}


	/**
	 * Delete
	 *
	 * @param $userId
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function delete( $userId ) {

		if ( !$user = $this->findById( $userId ) ) {
			return $this->setErrorMessage( 'Unable to find requested user.' );
		}
        UserDevice::where('user_id', $userId)->delete();

        $user->mosques()->where('user_id', $userId)->delete();

		// deleting user
		$user->delete();
	
		$this->setMessage( $user->name . ' has been deleted.' );

		return $user;

	}

	/**
	 * Helper method for create and register users
	 *
	 * @param $data
	 * @param null $avatar
	 * @return bool|mixed
	 */
	private function add( $data, $avatar = null ) {

		$data[ 'confirmation_code' ] = $hash = toolbox()->string()->uniqueHash( "users", "confirmation_code" );
		$data[ 'password' ] = bcrypt( $data[ 'password' ] );

		if ( !$user = $this->addRecord( $data ) ) {
			return $this->setErrorMessage( 'An unexpected error has occurred while signup. Please try later or contact admin.');
		}

		// Associating roles
//		if ( isset($data['is_administrative_user']) && $data['is_administrative_user'] ) {
//			if ( isset( $data[ 'roles' ]) && is_array( $data[ 'roles' ]) ) {
//				$user->roles()->sync( $data[ 'roles' ] );
//			}
//		} else {
//			// clearing all assigned roles.
//			$user->roles()->sync([]);
//		}

		// Avatar
		if ( $avatar ) {
			$ext = $avatar->getClientOriginalExtension();
			$avatarFilename = $user->id . '-' . Carbon::now()->timestamp . '.' . $ext;
			$avatarPath = $this->avatarStoragePath . '/' . $avatarFilename;
			Image::make( $avatar->getRealPath() )->fit( 48, 48 )->save( $avatarPath );
			$user->avatar = $avatarFilename;
			$user->save();
		}

		// Sending confirmation email
		if ( !$data[ 'is_confirmed' ] ) {
			toolbox()->email()
				->fromNoReply()
				->to( $data[ 'email' ], $data[ 'name' ] )
				->subject( 'Verify Your Account' )
				->message(
					toolbox()->frontend()->view( 'emails.confirmation' ), [
					'userName'         => $data[ 'name' ],
					'confirmationLink' => route( 'signup.confirmation', $hash )
				])
				->send();
		}

		$this->setData('success', 'A verification link has been sent to your email address.');
		$this->setData('details', 'Please click on the link that has just been sent to your email address to verify your email account to complete your registration.');
		$this->setMessage( $user->name . ' has been added.' );

		return $user;
	}

	/**
	 * Get homeowners list
	 *
	 * @param int $active
	 * @param string $field
	 * @param string $search
	 * @return array
	 */
	public function getHomeownersList( $active=1, $field='name', $search=null ) {
		$users = $this->getModel()->homeOwner();
		if( $active ) {
			$users->active();
			$users->confirmed();
		}
		if ( !is_null($search) ) {
			$users->where($field, 'LIKE', '%'.$search.'%');
		}
		return $users->get()->pluck($field, 'id');
	}
	

	/**
	 * Get mosque list
	 *
	 * @param int $active
	 * @return mixed
	 */
	public function getMosqueUserList() {
		return $this->getModel()
		->where( 'user_type', Role::TYPE_MOSQUE_ADMIN )
		->get()
		->pluck('name','id');
	}


	/**
	 * mosque list 
	 *
	 * @param $mosqueId
	 * @return mosque name id
	 * @throws \Exception
	 */
	public function getUserkMosqueList($mosqueId){	
		$data = [];
		foreach ($mosqueId as $key => $value) {
			$mosque =  Mosque::where('id', $value->mosque_id)->get();

			$data[$mosque[0]->id] = $mosque[0]->mosque_name;
		}
		return $data;

	}




	/**
	 * Get users list of specific role type.
	 *
	 * @param $role
	 * @param $active
	 * @return \Illuminate\Support\Collection
	 */
	public function getUsersListOfRoleType( $role, $active ) {
		$users = $this->getModel();
		if($active) {
			$users->active();
			$users->confirmed();
		}
		
		return $users->whereHas(
			'roles', function($query) use ($role) {
				$query->where('role_id', $role);
			})
			->get()
			->pluck('name', 'id');
	}

	public function getNotConfirmedUser(){
		$users = $this->getModel();
		$data['count'] = $users->where('is_confirmed','!=',1)->count() ;
		$data['data'] = $users->where('is_confirmed','!=',1)->paginate(10) ;
		return $data; 
		
	}
	
	/**
	 * @param $user_id
	 * @param $currentPassword
	 * @param $newPassword
	 * @return bool
	 */
	public function changePassword( $user_id, $currentPassword, $newPassword) {
		
		if ( !$user = $this->findById( $user_id ) ) {
			return $this->setErrorMessage('User not found.');
		}
		
		if(!Hash::check($currentPassword, $user->password)) {
			return $this->setErrorMessage("Incorrect current password.");
		}
		
		$user->password = bcrypt($newPassword);
		if(!$user->save()) {
			return $this->setErrorMessage("Unable to change password. Please contact admin or try later.");
		}
		
		return true;
	}
	
	public function canUploadPhotos( $user_id=null ) {
		return $this->__hasPermission($user_id, Permission::CAN_UPLOAD_PHOTOS);
	}
	
	public function canRemovePhotos($user_id = null) {
		return $this->__hasPermission($user_id, Permission::CAN_REMOVE_PHOTOS);
	}
	
	public function canReportViolations($user_id = null) {
		return $this->__hasPermission($user_id, Permission::CAN_REPORT_VIOLATIONS);
	}
	
	public function canSeeViolationDetails($user_id = null) {
		return $this->__hasPermission($user_id, Permission::CAN_SEE_VIOLATION_DETAILS);
	}
	
	private function __hasPermission($user_id, $permission_id ) {
		if($user_id == User::ADMIN_ID) {
			return true;
		}
		
		if(!$user = is_null($user_id) ? auth()->user() : $this->findById($user_id)) {
			return false;
		}
		
		return $user->hasPermission($permission_id);
	}

	public function saveTime($user_id){ 

		 DB::table('users')
            ->where('id', $user_id)
            ->update(array('visit' => Carbon::now()));

		if(!empty ($this->model->where('id', $user_id)->pluck('visit')[0]) ){
			return $this->model->where('id', $user_id)->pluck('visit')[0];
		}else{
			return Carbon::now();
		}
	}

	public function getVisitDate($user_id){
		return $this->model->where('id' , $user_id)->pluck('visit');
	}

	

	
}

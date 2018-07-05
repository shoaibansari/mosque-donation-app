<?php namespace App\Models;

use App\Notifications\Frontend\UserResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

	use Notifiable;

	const ADMIN_ID = 1;

	const TYPE_CUSTOMER = 0;
	const TYPE_MOSQUE_ADMIN = 2;
	const TYPE_DONOR = 3;
	// const TYPE_ADMINISTRATIVE = 1;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'phone', 'last_login_at', 'is_blocked', 'blocked_reason', 'is_confirmed',
		'confirmation_code', 'confirmed_at', 'avatar', 'updated_at', 'is_deleteable', 'user_type'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	protected $basePath, $baseUrl, $avatarsBasePath, $avatarsBaseUrl, $defaultAvatarUrl;

	public function __construct( array $attributes = [] ) {
		parent::__construct( $attributes );

		$this->basePath = storage_path( 'app' );
		$this->baseUrl = url( 'uploads' );
		$this->avatarsBasePath = $this->basePath . '/public/avatars';
		$this->avatarsBaseUrl = $this->baseUrl . '/public/avatars';
		$this->defaultAvatarUrl = $this->avatarsBaseUrl . '/no-user.jpg';

		// create directories, if not exist.
		toolbox()->filesystem()->createPath( $this->avatarsBasePath );
	}

	/**
	 * Roles relationship
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles() {
		return $this->belongsToMany( Role::class, 'user_roles', 'user_id' );
	}


	/**
	 * Mosques relationship
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function mosques() {
		return $this->hasMany( UserMosque::class, 'user_id', 'id' );
	}


	/**
	 * "active" scope
	 *
	 * @param $query
	 * @return mixed
	 */
	public function scopeActive( $query ) {
		return $query->where('is_blocked', 0);
	}
	
	/**
	 * "staff" or "administrative_user" scope
	 *
	 * @param $query
	 * @return mixed
	 */
	public function scopeStaff($query) {
		return $query->where('is_administrative_user', 1);
	}
	
	/**
	 * "active" scope
	 *
	 * @param $query
	 * @return mixed
	 */
	public function scopeHomeOwner($query) {
		return $query->where('is_administrative_user', '!=', 1);
	}

	/**
	 * "confirmed" scope
	 *
	 * @param $query
	 * @return mixed
	 */
	public function scopeConfirmed( $query ) {
		return $query->where('is_confirmed', 1);
	}

	/**
	 * Check isAdmin
	 *
	 * @return boolean
	 */
	public function isAdmin() {
		return $this->hasRole( Role::TYPE_ADMIN );
	}

	/**
	 * Is "administrative" type user
	 *
	 * @return bool
	 */
	public function isAdministrativeUser() {
		return $this->is_administrative_user;
	}

	/**
	 * Is "home-owner" type user
	 *
	 * @return bool
	 */
	public function isHomeOwner() {
		return !$this->is_administrative_user;
	}

	/**
	 * Is "customer" type user
	 *
	 * @return bool
	 */
	public function isCustomer() {
		return !$this->is_administrative_user;
	}


	/**
	 * Is Driver
	 */
	public function isMosqueAdmin() {
		return ($this->user_type == 2) ? 1 : 0;
	}

	/**
	 * Is Reviewer
	 */
	public function isDonor() {
		return ($this->user_type == 3) ? 1 : 0;
	}

	public function userMosques()
    {
        return $this->belongsToMany( UserMosque::class, 'mosque_id');
    }

    public function userDevice()
    {
        return $this->belongsTo( UserDevice::class, 'device_id');
    }

    public function mosqueDonations()
    {
        return $this->belongsTo( MosqueDonation::class, 'user_id');
    }

    public function userAccount()
    {
        return $this->belongsTo( UserAccount::class, 'user_id');
    }

	/**
	 * Check has role
	 *
	 * @param $roleId
	 * @return mixed
	 */
	public function hasRole( $roleId ) {
		if ( is_array( $roleId ) ) {
			foreach( $roleId as $role ) {
				if ( !$this->roles->contains( 'id', $role ) ) {
					return false;
				}
			}
			return true;
		}
		return $this->roles->contains('id', $roleId );
	}

	/**
	 * Check has permission
	 *
	 * @param $permissionId
	 * @return bool
	 */
	public function hasPermission( $permissionId ) {
		foreach( $this->roles as $role ) {
			if ( $role->permissions->contains( 'id', $permissionId ) ) {
				return true;
			}
		}
		return false;
	}

	public function hasAvatar() {
		return $this->avatar != '';
	}

	public function getAvatarUrl() {
		return $this->hasAvatar() ? ($this->avatarsBaseUrl . '/' . $this->avatar) : $this->defaultAvatarUrl;
	}

	public function getAvatarStoragePath() {
		return $this->avatarsBasePath;
	}

	public function getAvatarStorageUrl() {
		return $this->avatarsBaseUrl;
	}

	/**
	 * Send the password reset notification/email
	 *
	 * @param  string $token
	 * @return void
	 */
	public function sendPasswordResetNotification( $token ) {
		$this->notify( new UserResetPasswordNotification( $token, $this->email ) );
	}

}

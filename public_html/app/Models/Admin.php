<?php namespace App\Models;

use App\Notifications\Backoffice\AdminResetPasswordNotification;
use Illuminate\Notifications\Notifiable;

class Admin extends User
{
    use Notifiable;

    protected $table = 'users';

	protected $guard = 'admin';

    protected $avatarPath, $defaultAvatar;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

	/**
	 * Send the password reset notification/email.
	 *
	 * @param  string $token
	 * @return void
	 */
	public function sendPasswordResetNotification( $token ) {
		$this->notify( new AdminResetPasswordNotification( $token ) );
	}



}

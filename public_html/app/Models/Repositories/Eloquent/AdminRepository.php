<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 11/20/2017 11:09 PM
 */

namespace App\Models\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Repositories\AdminRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AdminRepository extends AbstractRepository implements AdminRepositoryInterface {

	public function __construct( Admin $admin ) {
		parent::__construct( $admin );
	}

	/**
//	 * @param Admin|integer|null $admin
//	 * @return \Illuminate\Database\Eloquent\Model|mixed|null
//	 */
//	public function getModel( $admin=null ) {
//		if ( is_null($admin) )
//			return $this->model;
//
//		if ( is_scalar( $admin ) )
//			$admin = $this->findById( $admin );
//
//		return $admin;
//	}

	public function update( $admin, $name, $email, $avatar ) {
		if ( !$admin = $this->getModel( $admin ) ) {
			$this->errorMessage = "Admin not found.";

			return false;
		}

		$admin->name = ucwords( $name );
		$admin->email = $email;
		if ( $avatar ) {
			$admin->avatar = $avatar;
		}
		$admin->save();

		return true;
	}

	/**
	 * @param Admin|integer $admin
	 * @param string $currentPassword
	 * @param string $newPassword
	 * @return \Illuminate\Database\Eloquent\Model|mixed|null
	 */
	public function changePassword( $admin, $currentPassword, $newPassword ) {

		if ( !$admin = $this->getModel( $admin ) ) {
			$this->errorMessage = "Admin not found.";
			return false;
		}

		if ( !Hash::check( $currentPassword, $admin->password ) ){
			$this->errorMessage = "Incorrect current password.";

			return false;
		}


		$admin->password = bcrypt( $newPassword );
		if ( !$admin->save() ) {
			$this->errorMessage = "Unable to update password. Please contact admin.";
			return false;
		}

		return true;
	}
}
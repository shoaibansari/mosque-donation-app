<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Requests\Backoffice\AdminPasswordUpdateRequest;
use App\Http\Requests\Backoffice\AdminProfileUpdateRequest;
use App\Models\Repositories\Eloquent\AdminRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
	protected $adminRepository, $user, $avatarStoragePath;

	public function __construct( AdminRepository $adminRepository) {
		$this->adminRepository = $adminRepository;
		$this->avatarStoragePath = $this->adminRepository->getModel()->getAvatarStoragePath();

	}

	public function getProfile() {
		
		return view( toolbox()->backend()->view('users.profile') );
	}

	public function postProfile( AdminProfileUpdateRequest $request ) {

		$admin = auth('admin')->user();

		$avatarFilename = null;
		$oldAvatar = '';
		$newAvatar = '';
		if ( $request->avatar ) {
			$oldAvatar = $this->avatarStoragePath . '/' . $admin->avatar;
			$ext = $request->avatar->getClientOriginalExtension();
			$avatarFilename = $admin->id . '-' . Carbon::now()->timestamp . '.' . $ext;
			$newAvatar = $this->avatarStoragePath . '/' . $avatarFilename;

			Image::make( $request->avatar->getRealPath() )->fit( 48, 48 )->save( $newAvatar );
		}

		if ( !$this->adminRepository->update( $admin, $request->name, $request->email, $avatarFilename ) ) {

			// if new avatar uploaded then remove the new one due to validation error.
			if ( $newAvatar ) {
				@unlink( $newAvatar );
			}
			return redirect( route( 'admin.edit' ) )->with( 'error', $this->adminRepository->getErrorMessage() );
		}

		if ( $newAvatar ) {
			@unlink( $oldAvatar );
		}
		return redirect( route( 'admin.edit' ) )->with( 'success', 'Profile has been updated.' );
	}

	public function postChangePassword( AdminPasswordUpdateRequest $request ) {

		if ( !$this->adminRepository->changePassword( auth('admin')->user(), $request->current_password, $request->password ) ) {
			return redirect( route( 'admin.edit' ) )->with( 'error', $this->adminRepository->getErrorMessage() );
		}

		return redirect( route( 'admin.edit' ) )->with( 'success', 'Password has been changed.' );
	}

	public function getRemoveAvatar() {
		$admin = auth( 'admin' )->user();

		$avatarFile = $this->avatarStoragePath . '/' . $admin->avatar;
		$admin->avatar = '';
		$admin->save();

		@unlink( $avatarFile );
		return redirect( route( 'admin.edit' ) )->with( 'success', 'Avatar has been removed.' );
	}

}

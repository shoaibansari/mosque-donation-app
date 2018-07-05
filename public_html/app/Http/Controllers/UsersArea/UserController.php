<?php

namespace App\Http\Controllers\UsersArea;

use App\Http\Requests\UsersArea\UserPasswordUpdateRequest;
use App\Http\Requests\UsersArea\UserProfileUpdateRequest;
use App\Models\Repositories\Eloquent\UserRepository;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
	protected $userRepository, $user, $avatarStoragePath;

	public function __construct( UserRepository $userRepository ) {
		$this->userRepository = $userRepository;
		$this->avatarStoragePath = $this->userRepository->getModel()->getAvatarStoragePath();
	}

	public function getProfile() {
		return view( toolbox()->userArea()->view( 'users.profile' ) );
	}

	public function postProfile( UserProfileUpdateRequest $request ) {

		$user = auth()->user();
		$data = $request->only(['name']);
		if ( !$this->userRepository->update( $user->id, $data, $request->avatar) ) {
			return redirect( route( 'profile.edit' ) )->with( 'error', $this->userRepository->getErrorMessage() );
		}

		return redirect( route( 'profile.edit' ) )->with( 'success', 'Profile has been updated.' );
	}

	public function postChangePassword( UserPasswordUpdateRequest $request ) {

		if ( !$this->userRepository->changePassword( auth()->user()->id, $request->current_password, $request->password ) ) {
			return redirect( route( 'profile.edit' ) )->with( 'error', $this->userRepository->getErrorMessage() );
		}

		return redirect( route( 'profile.edit' ) )->with( 'success', 'Password has been changed.' );
	}

	public function getRemoveAvatar() {
		$user = auth( )->user();

		$avatarFile = $this->avatarStoragePath . '/' . $user->avatar;
		$user->avatar = '';
		$user->save();

		@unlink( $avatarFile );

		return redirect( route( 'profile.edit' ) )->with( 'success', 'Avatar has been removed.' );
	}

}

<?php

namespace App\Http\Controllers\UsersArea;

use App\Http\Requests\UsersArea\UserPasswordUpdateRequest;
use App\Http\Requests\UsersArea\UserProfileUpdateRequest;
use App\Models\Repositories\Eloquent\UserRepository;
use Carbon\Carbon;
use App\Models\Mosque;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\Repositories\Eloquent\DonationRepository;

class UserController extends Controller
{
	protected $userRepository, $user, $avatarStoragePath, $donationRepo;

	public function __construct( UserRepository $userRepository, DonationRepository $donationRepository ) {
		$this->userRepository = $userRepository;
		$this->avatarStoragePath = $this->userRepository->getModel()->getAvatarStoragePath();
		 $this->donationRepo = $donationRepository;
	}

	public function getProfile() {
		$mosque_admin_id = \Auth::id() ; 
        $visitDate = $this->userRepository->saveTime($mosque_admin_id );

        $notifications = $this->donationRepo->getLatestDonation($visitDate);
       
        $mosque = new Mosque();
		return view( toolbox()->userArea()->view( 'users.profile' ) , compact('notifications', 'mosque'));
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

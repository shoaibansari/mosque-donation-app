<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Repositories\Eloquent\JobRepository;
use App\Models\Repositories\Eloquent\UserDeviceRepository;
use App\Models\Repositories\Eloquent\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Password;

class UserController extends ApiController {
	
	private $userRepo, $deviceRepo, $jobRepo;
	
	/**
	 * UserController constructor.
	 * @param UserRepository $userRepo
	 * @param UserDeviceRepository $deviceRepo
	 */
	public function __construct(UserRepository $userRepo, UserDeviceRepository $deviceRepo, JobRepository $jobRepo) {
		$this->userRepo = $userRepo;
		$this->deviceRepo = $deviceRepo;
		$this->jobRepo = $jobRepo;
	}
	
	/**
	 * Get user details
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function getUser(Request $request) {
		$user = $this->deviceRepo->findUserByToken($request->token);
		
		return $this->sendData($user);
	}


    /**
     * User Profile Update
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function updateProfile( Request $request ) {
        $user = auth()->user();
        $user = $this->deviceRepo->findUserByToken($request->token);
        $data = $request->except('token');

        if ( !$this->userRepo->updateUserProfile( $user->id, array_filter($data)) ) {
            $error = 'blank field is required';
        }
        return $this->sendResponse('Update successfully');
    }

}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Repositories\Eloquent\UserDeviceRepository;
use App\Models\Repositories\Eloquent\UserRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AuthController extends ApiController {
	
	use AuthenticatesUsers, SendsPasswordResetEmails;
	
	private $userRepo, $deviceRepo;
	
	public function __construct(UserRepository $userRepo, UserDeviceRepository $deviceRepo) {
		$this->userRepo = $userRepo;
		$this->deviceRepo = $deviceRepo;
	}
	
	public function login(Request $request) {

		if(!$this->validate(
			$request, [
			'email'     => 'required|email',
			'password'  => 'required',
		])) {
			$error = trans('auth.failed');
			if($this->getValidationMessages()->has('device_id')) {
				$error = 'Device-Id is missing';
			}
			
			return $this->sendErrorResponse($error, $this->getValidationMessages());
		}
		
		if($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);
			
			return $this->sendLockoutResponse($request);
		}
		
		if($this->attemptLogin($request)) {
			
			$user = auth()->user();
			
			$err = null;
			if($user->is_blocked) {
				$err = 'Your account has been disabled. Please contact admin.';
			}
			else if(!$user->is_confirmed) {
				$err = 'Your email account is not yet verified. Please check your email and follow the instructions to verify your account.';
			}
						
			if($err) {
				auth()->logout();
				
				return $this->sendErrorResponse($err);
			}

			// Updating last login time.
		    $user->last_login_at = Carbon::now();
	    	$user->save();
			
			$request->session()->regenerate();
			$this->clearLoginAttempts($request);
			
			// adding or update user device
			$data['platform'] = $request->platform;
			$data['os_version'] = $request->os_version;
			$data['gcm_id'] = $request->gcm_id;
			$data['notifications'] = $request->notifications;
			$data['badges'] = $request->badges;
			$data['badges'] = $request->badges;
			$data['latitude'] = $request->latitude;
			$data['longitude'] = $request->longitude;
			$token = $this->deviceRepo->addOrUpdate($request->device_id, $user->id, $data);


			
			return $this->sendResponse('Login successfully', ['token' => $token, 'user_type' => $user->user_type]);
		}
		
		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);
		
		return $this->sendErrorResponse(trans('auth.failed'), [$this->username() => trans('auth.failed')]);
	}
	
	/**
	 * Logout
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function logout(Request $request) {
		$this->deviceRepo->removeToken($request->token);
		auth()->logout();
		
		return $this->sendResponse('Logged out successfully.');
	}
	
	/**
	 * Signup
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function signup(Request $request) {
		
		if(!$this->validate(
			$request, [
            'name'    => 'required',
			'email'    => 'required|email|unique:users,email',
			'password' => 'required|min:8',
            'user_type' => 'required',
            'device_id' => 'required'
		])) {
			return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
		}
		
		$data = $request->only(['name','email','password','user_type']);
		if(!$user = $this->userRepo->register($data)) {
			return $this->sendErrorResponse($this->userRepo->getErrorMessage());
		}
		
		return $this->sendResponse('Signup successfully', $user);
	}
	
	/**
	 * Forgot Password
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function forgotPassword(Request $request) {
		
		if(!$this->validate($request, ['email' => 'required|email'])) {
			return $this->sendErrorResponse('Required a valid email address', $this->getValidationMessages());
		}
		
		$response = $this->broker()->sendResetLink(
			$request->only('email')
		);
		
		return $response == Password::RESET_LINK_SENT
			? $this->sendResponse(trans($response))
			: $this->sendErrorResponse(trans($response));
	}
	

	
}
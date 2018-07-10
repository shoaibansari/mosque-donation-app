<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Repositories\Eloquent\UserAccountRepository;
use App\Models\Repositories\Eloquent\UserDeviceRepository;
use App\Models\User;
use Illuminate\Http\Request;

class UserAccountController extends ApiController {
	
	private $userAccountRepo, $userDevice;

    public function __construct( UserAccountRepository $userAccountRepo, UserDeviceRepository $userDevice) {
        $this->userAccountRepo  = $userAccountRepo;
        $this->userDevice  = $userDevice;
    }

    /**
     * Add Wallet
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request) {

    	if(!$this->validate(
            $request, [
            'payment_method'     => 'required',
            'paypal_email'       => 'required|unique:user_accounts,paypal_email',         
        ])) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }

        $user = $this->userDevice->findUserByToken($request->token);
        $data['user_id'] = $user->id;
        $data['payment_method'] = $request->payment_method;
        $data['paypal_email'] = $request->paypal_email;

        if ( !$wallet = $this->userAccountRepo->create( $data )) {
            return $this->sendErrorResponse('Unable to create wallet.');
        }
        return $this->sendResponse('Successfully Add Payment Method', $wallet);
    }

     /**
     * Get Wallet
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

     public function searchUserByToken(Request $request){

        if(!$this->validate(
            $request, [
            'token'     => 'required'     
        ])) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }

        $user = $this->userDevice->findUserByToken($request->token);
        $data['user_id'] = $user->id;
        
        if ( !$wallet = $this->userAccountRepo->findUser( $data )) {
            return $this->sendErrorResponse('Unable to create wallet.');
        }

        return $this->sendResponse('Successfully Fetch', $wallet);
     }

}
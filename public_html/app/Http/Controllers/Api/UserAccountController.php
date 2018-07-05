<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Repositories\Eloquent\UserAccountRepository;

class UserAccountController extends ApiController {
	
	private $userAccountRepo;

    public function __construct( UserAccountRepository $userAccountRepo ) {
        $this->userAccountRepo     = $userAccountRepo;
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
            'user_id'            => 'required',
            'payment_method'     => 'required',
            'paypal_email'       => 'required',         
        ])) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }

        $data = $request->except(['token']);        
        if ( !$wallet = $this->userAccountRepo->create( $data )) {
            return $this->sendErrorResponse('Unable to create wallet.');
        }
        return $this->sendData($wallet);
    }
}
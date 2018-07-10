<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Repositories\Eloquent\MosqueDonationRepository;
use App\Models\Repositories\Eloquent\UserDeviceRepository;
use App\Http\Requests\Backoffice\DonationSendRequest;
use Illuminate\Http\Request;
use App\Models\MosqueDonation;
use Carbon\Carbon;

class MosqueDonationController extends ApiController {

    private $donationRepo;

    public function __construct(MosqueDonationRepository $donationRepo, UserDeviceRepository $userDevice) {
        $this->donationRepo = $donationRepo;
        $this->userDevice  = $userDevice;
    }


    public function store( Request $request ){

        if(!$this->validate(
            $request, [
            'mosque_id'        => 'required',
            'donation_id'      => 'required',
            'email'            => 'required|email',
            'payment'          => 'required',
            'payment_method'   => 'required',
        ],
            [
                'payment.required' => 'Please enter payment'
            ]
        )) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }
         $donationData = $request->except(['token', 'donation_id', 'payment']);
    
            foreach ($request->payment as $key => $value) {

                $donationData['payment'] = $value;
                $donationData['donation_id'] = $request->donation_id[$key];
                
                $user = $this->userDevice->findUserByToken($request->token);
                $donationData['user_id'] = $user->id;

               if ( !$donation = $this->donationRepo->create( $donationData )) {
                return $this->sendErrorResponse('didn\'t receive your donations.');
            }
        }        

        return $this->sendResponse('Mosque Donation has been received Successfully.');
    }

    public function view(Request $request) {

        if(!$this->validate(
            $request, [
            'donation_id'      => 'required'
        ]
        )) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }
       
        if ( !$donation = $this->donationRepo->getDonationDetail( $request->donation_id )) {
            return $this->sendErrorResponse('Unable to find your donation.');
        }

        return $this->sendResponse('Successfully Fetch.', $donation);
    }
    
    public function getPastDonation(Request $request) {
        $user = $this->userDevice->findUserByToken($request->token);
        $userId['user_id'] = $user->id;

        if ( !$donation = $this->donationRepo->getPastDonationDetail( $userId )) {
            return $this->sendErrorResponse('Unable to find your past donation.');
        }
      
        return $this->sendResponse('Successfully Fetch.', $donation);
    }

    public function getDonationSummary(Request $request){
        $user = $this->userDevice->findUserByToken($request->token);
        
        if( !$data = $this->donationRepo->getFundsByYear($user->id, $request->year) ){
            return $this->sendErrorResponse('No funds found');
        } 
        return $this->sendResponse( 'A attachment  has been sent to your email address.');
       

    }


} 
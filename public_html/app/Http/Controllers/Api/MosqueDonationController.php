<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Repositories\Eloquent\MosqueDonationRepository;
use App\Http\Requests\Backoffice\DonationSendRequest;
use Illuminate\Http\Request;


class MosqueDonationController extends ApiController {

    private $donationRepo;

    public function __construct(MosqueDonationRepository $donationRepo) {
        $this->donationRepo = $donationRepo;
    }


    public function store( Request $request ){

        if(!$this->validate(
            $request, [
            'user_id'          => 'required',
            'mosque_id'        => 'required',
            'donation_id'      => 'required',
            'email'            => 'required|email',
            'payment'          => 'required|integer'
        ],
            [
                'payment.required' => 'Please enter payment',
                'payment.integer' => 'Please enter correct payment',
            ]
        )) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }

        $donationData = $request->except(['token']);
        if ( !$mosque = $this->donationRepo->create( $donationData )) {
            return $this->sendErrorResponse('didn\'t receive your donations.');
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
        if(!$this->validate(
            $request, [
            'user_id'      => 'required'
        ]
        )) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }
        if ( !$donation = $this->donationRepo->getPastDonationDetail( $request->user_id )) {
            return $this->sendErrorResponse('Unable to find your past donation.');
        }

        return $this->sendResponse('Successfully Fetch.', $donation);
    }


}
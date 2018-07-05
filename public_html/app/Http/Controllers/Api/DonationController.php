<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Donation;
use App\Models\Repositories\Eloquent\DonationRepository;
use App\Models\Repositories\Eloquent\MosqueRepository;
use App\Models\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;

class DonationController extends ApiController {

	private $mosqueRepo, $donationRepo, $userRepo;

    public function __construct(MosqueRepository $mosqueRepo, DonationRepository $donationRepository, UserRepository $userRepo) {
        $this->mosqueRepo    = $mosqueRepo;
        $this->donationRepo  = $donationRepository;
        $this->userRepo      = $userRepo;
    }

	/**
     * Get mosque donation details
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getMosqueDonation(Request $request) {

    	$donation = $this->donationRepo->getDonationMosque( $request->mosque_id );
        
        if (count($donation) == 0) {
            return $this->sendErrorResponse('Don\'t have for Donation.');
        }else if(count($donation) > 0) {
            return $this->sendResponse('Successfully Fetch.', $donation);

        }
    }



}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Repositories\Eloquent\MosqueRepository;
use Illuminate\Http\Request;
use App\Models\Repositories\Eloquent\UserMosqueRepository;
use App\Models\Repositories\Eloquent\UserRepository;

class MosqueController extends ApiController {

    private $mosqueRepo, $userMosqueRepo, $userRepo;

    public function __construct(MosqueRepository $mosqueRepo, UserMosqueRepository $userMosqueRepo, UserRepository $userRepo) {
        $this->mosqueRepo     = $mosqueRepo;
        $this->userMosqueRepo =  $userMosqueRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Get mosque details
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getMosque(Request $request) {
        if (!$mosque = $this->mosqueRepo->findById($request->mosque_id)){
            return $this->sendErrorResponse('Unable to find mosque.');
        }
        return $this->sendData($mosque);
    }

    /**
     * Get mosque details
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getAllMosque(Request $request) {

        $mosque = $this->mosqueRepo->getResultset($request->only(['page', 'perPage']), true);
        return $this->sendData($mosque);
    }
    

    public function store( Request $request ){

        if(!$this->validate(
            $request, [
            'mosque_name'            => 'required',
            'authorized_name'        => 'required',
            'email'                  => 'required|email|unique:users,email',
            'address'                => 'required|min:4|max:100',
            'zip_code'               => 'required|numeric',
            'phone'                  => 'required|min:7|max:12',
            'bank_account'           => 'required|min:10',
            'paypal_email'           => 'required|email',
            'tax_id'                 => 'required|min:10',
            'password'               => 'required|min:4|max:40',
            'longitude'              => 'required',
            'latitude'               => 'required',
        ])) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }

        $mosqueData = $request->except(['token']);
        $mosqueData['is_active'] = 0;
        if ( !$mosque = $this->mosqueRepo->create( $mosqueData )) {
            return $this->sendResponse('Not Create Mosque.');
        }

        $userData = $request->only(['password', 'email', 'phone']);
        $userData['name'] = $request->get('authorized_name');
        $userData['user_type'] = 2;
        $userData['is_confirmed'] = 0;
        $user = $this->userRepo->create($userData);
        $mosqueData =  $this->userMosqueRepo->assignToUser( $user->id, $mosque->id );
        return $this->sendData($mosque);
    }


    public function searchMosque(Request $request){

        if(!$this->validate(
            $request, [
            'latitude'         => 'required',
            'longitude'        => 'required',
        ])) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }
        
        if(!$mosque = $this->mosqueRepo->checkNearByMosque($request->latitude, $request->longitude)){
            return $this->sendResponse('Not available Mosque.');
        } 
        
        return $this->sendResponse('Successfully Fetch.', $mosque);
    }

}
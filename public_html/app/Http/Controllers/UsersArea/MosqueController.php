<?php

namespace App\Http\Controllers\UsersArea;

use App\Http\Controllers\Controller;
use App\Models\UserMosque;
use App\Models\Mosque;
use Illuminate\Http\Request;
use App\DataTables\UsersArea\UserMosquesDataTable;
use App\DataTables\UsersArea\UserLocationsDataTable;
use App\Models\Repositories\Eloquent\MosqueRepository;
use App\Models\Repositories\Eloquent\UserRepository;
use App\Models\Repositories\Eloquent\UserMosqueRepository;
use App\Http\Requests\UsersArea\MosqueCreateRequest;
use App\Models\Repositories\Eloquent\DonationRepository;

class MosqueController extends Controller
{
	protected $userRepo, $mosqueRepo, $userMosqueRepo;

	public function __construct(
		UserRepository $userRepo,
		MosqueRepository $mosqueRepo,
		UserMosqueRepository $userMosqueRepo,
		DonationRepository $donationRepository

	) {
		$this->userRepo = $userRepo;
		$this->mosqueRepo = $mosqueRepo;
		$this->userMosqueRepo = $userMosqueRepo;
		 $this->donationRepo = $donationRepository;
	}

	/**
	 * Manage
	 *
	 * @param MosqueDataTable $dataTable
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function manage( UserMosquesDataTable $dataTable ) { 
		$mosque_admin_id = \Auth::id() ; 
        $visitDate = $this->userRepo->saveTime($mosque_admin_id );

        $notifications = $this->donationRepo->getLatestDonation($visitDate);
       
        $mosque = new Mosque();
		toolbox()->pluginsManager()->plugins(['datatables']);
		return $dataTable->render( toolbox()->userArea()->view( 'mosque.manage' ), compact('notifications' , 'mosque') );
	}


	/**
	 * Edit View
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function edit( $id ) {
			
		if ( !$mosque = $this->mosqueRepo->findById( $id ) ) {
			return redirect( route( 'mosque.manage' ) )->with( 'error', 'Unable to find requested Mosque.' );
		}

		if (!$this->userMosqueRepo->checkMosqueUser( $id )) {
			return redirect( route( 'mosque.manage' ) )->with( 'error', 'Sorry you Can\'t edit this mosque.' );
		}else if ( !$mosque->is_active == 1 ) {
			return redirect( route( 'mosque.manage' ) )->with( 'error', 'Sorry Your Mosque is not active.' );
		}
				
		$action = 'edit';
		$allMosqueUsers = $this->userRepo->getMosqueUserList();
		toolbox()->pluginsManager()->plugins(['bs-daterangepicker-2.0', 'chosen']);
		return view(
			toolbox()->userArea()->view( 'mosque.edit' ),
			compact( 'action', 'mosque')
		);
	}

	/**
	 * Update record
	 *
	 * @param MosqueCreateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( MosqueCreateRequest $request ) {

		$data = $request->except( ['_token'] );
		if ( !$mosque = $this->mosqueRepo->update( $request->id, $data) ) {
			return redirect()->back()->with( 'error', $this->mosqueRepo->getErrorMessage() );
		}

		// $this->userMosqueRepo->delete($request->id);

		// foreach ($request->user_id as $key => $value) {
		// 	$mosque = $this->userMosqueRepo->assignToUser($value, $request->id );
		// }

		return redirect( route( 'mosque.manage' ) )->with( 'success', $this->mosqueRepo->getMessage() );
	}
    



}
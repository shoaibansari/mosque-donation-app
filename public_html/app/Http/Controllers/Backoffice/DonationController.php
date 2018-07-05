<?php

namespace App\Http\Controllers\Backoffice;

use App\DataTables\Backoffice\DonationDataTable;
use App\DataTables\Backoffice\MosqueDonationDataTable;
use App\DataTables\Backoffice\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\DonationCreateRequest;
use App\Http\Requests\Backoffice\UserCreateRequest;
use App\Models\Donation;
use App\Models\Repositories\Eloquent\DonationRepository;
use App\Models\Repositories\Eloquent\MosqueRepository;
use App\Models\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;

class DonationController extends Controller {

	protected $userRepo, $donationRepo, $mosqueRepo;

	public function __construct( UserRepository $userRepository, DonationRepository $donationRepository, MosqueRepository $mosqueRepository) {
		$this->userRepo = $userRepository;
		$this->donationRepo = $donationRepository;
		$this->mosqueRepo = $mosqueRepository;
	}

	/**
	 * Manage
	 *
	 * @param UsersDataTable $dataTable
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function manage( DonationDataTable $dataTable ) {
		toolbox()->pluginsManager()->plugins(['datatables']);
		return $dataTable->render( toolbox()->backend()->view( 'donation.manage' ) );
	}

    
    /**
	 * Create Donation
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() { 

		$action = 'create';
		$mosque =  $this->mosqueRepo->getMosqueList(true);
		
		return view( toolbox()->backend()->view( 'donation.edit' ), compact( 'action', 'mosque') );
	}

    
    /**
	 * View Funds
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function view(MosqueDonationDataTable $dataTable) { 

		$action = 'view';
		$donation = Donation::where('id', request()->route('id') )->firstOrFail();
		toolbox()->pluginsManager()->plugins(['datatables']);
		return $dataTable->render( toolbox()->backend()->view( 'donation.view' ), compact('action', 'donation'));
	}

	/**
	 * Store new Donation
	 *
	 * @param UserCreateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( DonationCreateRequest $request ) {
	
		$data = $request->except( ['_token'] );
		if ( !$user = $this->donationRepo->create( $data ) ) {
			return redirect( route( 'admin.donation.manage' ) )->with( 'error', $this->donationRepo->getErrorMessage() );
		}
		return redirect( route( 'admin.donation.manage' ) )->with( 'success', $this->donationRepo->getMessage() );
	}

	/**
	 * Edit View
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function edit( $id ) {
		if ( !$donation = $this->donationRepo->findById( $id ) ) {
			return redirect( route( 'admin.donation.manage' ) )->with( 'error', 'Unable to find requested.' );
		}

		$action = 'edit';
        $mosque =  $this->mosqueRepo->getMosqueList(true);
		return view( toolbox()->backend()->view( 'donation.edit' ), compact( 'action', 'donation', 'mosque'));
	}

	/**
	 * Update record
	 *
	 * @param UserUpdateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( DonationCreateRequest $request ) {

		$data = $request->except( ['_token'] );
		if ( !$donation = $this->donationRepo->update( $request->id, $data ) ) {
			return redirect( route( 'admin.donation.manage' ) )->with( 'error', $this->donationRepo->getErrorMessage() );
		}

		return redirect( route( 'admin.donation.manage' ) )->with( 'success', $this->donationRepo->getMessage() );
	}


	/**
	 * Delete donation
	 *
	 * @param $donationId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete( $donationId ) {
		if ( !$donation = $this->donationRepo->delete( $donationId ) ) {
			return redirect( route( 'admin.donation.manage' ) )->with( 'error', $this->donationRepo->getErrorMessage() );
		}

		return redirect( route( 'admin.donation.manage' ) )->with( 'success', $this->donationRepo->getMessage() );
	}
	
	
	
}

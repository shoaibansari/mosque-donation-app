<?php

namespace App\Http\Controllers\Backoffice;

use App\DataTables\Backoffice\UserLocationsApprovalDataTable;
use App\Http\Controllers\Controller;
use App\Models\Repositories\Eloquent\UserLocationRepository;
use App\Models\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;

class UserLocationController extends Controller
{

	protected $userRepo, $userLocationRepo;

	public function __construct(
		UserRepository $userRepository,
		UserLocationRepository $userLocationRepository
	) {
		$this->userRepo = $userRepository;
		$this->userLocationRepo = $userLocationRepository;
	}

	/**
	 * Pending list/manage
	 *
	 * @param UserLocationsApprovalDataTable $dataTable
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function pending( UserLocationsApprovalDataTable $dataTable ) {
		toolbox()->pluginsManager()->plugins(['datatables']);
		return $dataTable->render( toolbox()->backend()->view( 'userLocations.pending') );
	}


	/**
	 * Delete
	 *
	 * @param $userLocationId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete( $userLocationId ) {

		if ( !$job = $this->userLocationRepo->delete( $userLocationId ) ) {
			return redirect( route( 'admin.users.locations.pending' ) )->with( 'error', $this->userLocationRepo->getErrorMessage() );
		}

		return redirect( route( 'admin.users.locations.pending' ) )->with( 'success', $this->userLocationRepo->getMessage() );
	}

	/**
	 * Review of location approval request
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function review( $id ) {
		if ( !$location = $this->userLocationRepo->findById( $id ) ) {
			return redirect( route( 'admin.users.locations.pending' ) )->with( 'error', 'Unable to find requested location.' );
		}

		$action = 'view';
		return view( toolbox()->backend()->view( 'userLocations.review' ), compact( 'action', 'id', 'location' ) );
	}

	/**
	 * Update user location's status
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function status( Request $request ) {

		if ( !$location = $this->userLocationRepo->status( $request->id, $request->status ) ) {
			if ( $request->expectsJson() ) {
				return toolbox()->response()->error( $this->userLocationRepo->getErrorMessage() )->send();
			}
			return redirect( route( 'admin.users.locations.pending' ) )->with( 'error', $this->userLocationRepo->getErrorMessage() );
		}

		if ( $request->expectsJson() ) {
			return toolbox()->response()->success( $this->userLocationRepo->getMessage(), ['status'=> $location->status()] )->send();
		}

		return redirect( route( 'admin.users.locations.pending' ) )->with( 'success', $this->userLocationRepo->getMessage() );
	}

}

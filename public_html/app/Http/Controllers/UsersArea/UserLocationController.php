<?php

namespace App\Http\Controllers\UsersArea;

use App\DataTables\UsersArea\LocationViolationsViewDataTable;
use App\DataTables\UsersArea\UserLocationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Middleware\HomeOwner;
use App\Http\Requests\UsersArea\LocationCreateRequest;
use App\Models\Repositories\Eloquent\StateRepository;
use App\Models\Repositories\Eloquent\UserLocationRepository;
use App\Models\Repositories\Eloquent\UserRepository;
use App\Models\UserLocation;
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

		$this->middleware(HomeOwner::class);
	}

	/**
	 * Manage list
	 *
	 * @param UserLocationsDataTable $dataTable
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function manage( UserLocationsDataTable $dataTable ) {
		toolbox()->pluginsManager()->plugins(['datatables']);
		return $dataTable->render( toolbox()->userArea()->view( 'locations.manage') );
	}
	
	public function view( $locationId, LocationViolationsViewDataTable $dataTable ) {
		
		if ( !$location = auth()->user()->locations()->find($locationId) ) {
			return redirect(route('users.locations'))->with('error', 'Location not found.');
		}
		
		$action = 'view';
		return $dataTable->render( toolbox()->userArea()->view('locations.view'), compact('action', 'location'));
	}
	
	public function create() {
		
		if ( UserLocationRepository::instance()->getPendingLocationsCount( auth()->user()->id ) > 0) {
			return redirect(route('users.locations'))->with('error', 'You can do only one request at a time.');
		}
		
		$action = 'create';
		$allStates = StateRepository::instance()->getActiveList();
		return view(toolbox()->userArea()->view('locations.edit'), compact('action', 'allStates' ));
	}
	
	public function store(LocationCreateRequest $request) {
		
		$data = $request->except('_token');
		
		$location = $this->userLocationRepo->addRecord( $data + [ 'homeowner_id' => auth()->user()->id] );
		
		$this->userRepo->sendLocationApprovalRequestToAdmin($location );
		
		return redirect(route('users.locations'))->with('success', 'Location request has been sent.');
	
	}

	/**
	 * Delete
	 *
	 * @param $userLocationId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete( $userLocationId ) {
		
		if ( !$location = $this->userLocationRepo->delete( $userLocationId, auth()->user() ) ) {
			return redirect(route('users.locations'))->with('error', $this->userLocationRepo->getErrorMessage());
		}
		
		return redirect( route( 'users.locations' ) )->with( 'success', 'Location has been deleted.' );
	}


}

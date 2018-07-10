<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\DataTables\Backoffice\MosquesDataTable;
use App\DataTables\Backoffice\JobLocationsDataTable;
use App\Http\Requests\Backoffice\JobCreateRequest;
use App\Http\Requests\Backoffice\MosqueCreateRequest;
use App\Http\Requests\Backoffice\MosqueUpdateRequest;
use App\Models\UserMosque;
use App\Models\Repositories\Eloquent\UserRepository;
use App\Models\Repositories\Eloquent\UserMosqueRepository;
use App\Models\Repositories\Eloquent\MosqueRepository;
use App\Models\Repositories\Eloquent\StateRepository;
use App\Models\User;
use App\Models\Mosque;
use Illuminate\Http\Request;

class MosqueController extends Controller
{

	protected $userRepo, $mosqueRepo, $userMosqueRepo, $stateRepo;

	public function __construct(
		UserRepository $userRepo,
		MosqueRepository $mosqueRepo,
		UserMosqueRepository $userMosqueRepo,
		StateRepository $stateRepo

	) {
		$this->userRepo = $userRepo;
		$this->mosqueRepo = $mosqueRepo;
		$this->userMosqueRepo = $userMosqueRepo;
		$this->stateRepo = $stateRepo;
	}

	/**
	 * Manage
	 *
	 * @param MosquesDataTable $dataTable
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function manage( MosquesDataTable $dataTable ) {
		$notifications = $this->userRepo->getNotConfirmedUser();
		toolbox()->pluginsManager()->plugins(['datatables']);
		return $dataTable->render( toolbox()->backend()->view( 'mosque.manage'), compact('notifications') );
	}

	/**
	 * Delete
	 *
	 * @param $mosqueId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete( $mosqueId ) {

		if ( !$mosque = $this->mosqueRepo->delete( $mosqueId ) ) {
			return redirect( route( 'admin.mosque.manage' ) )->with( 'error', $this->mosqueRepo->getErrorMessage() );
		}

		return redirect( route( 'admin.mosque.manage' ) )->with( 'success', $this->mosqueRepo->getMessage() );
	}

	/**
	 * Create form
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {
		$action = 'create';
		$allMosqueUsers = $this->userRepo->getMosqueUserList(true,true);
		$states = $this->stateRepo->getStates(true);
		$selectedMosqueUsers = null;
		//$allMosque = $this->areaRepo->getUnassignedAreaList();
		toolbox()->pluginsManager()->plugins( ['bs-daterangepicker-2.0', 'chosen' ]);
		return view( toolbox()->backend()->view( 'mosque.edit' ), compact( 'action', 'allMosqueUsers', 'selectedMosqueUsers', 'states') );
	}

	/**
	 * Insert new record
	 *
	 * @param MosqueCreateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( MosqueCreateRequest $request ) {
		$mosqueData = $request->except(['_token']);

		if ( !$mosque = $this->mosqueRepo->create( $mosqueData )) {
			return redirect()->back()->with( 'error', $this->mosqueRepo->getErrorMessage() );
		}

		if(empty($request->password)){
            foreach ($request->user_id as $key => $value) {
                $mosqueData = $this->userMosqueRepo->assignToUser($value, $mosque->id );
            }
        }else{
		    $userData = $request->only(['password', 'email', 'phone']);
            $userData['name'] = $request->get('authorized_name');
            $userData['user_type'] = 2;
            $userData['is_confirmed'] = $request->get('is_confirmed');
		    $user = $this->userRepo->create($userData);
            $mosqueData = $this->userMosqueRepo->assignToUser( $user->id, $mosque->id );
        }

		return redirect( route( 'admin.mosque.manage' ) )->with( 'success', $this->mosqueRepo->getMessage() );
	}

	/**
	 * Edit View
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function edit( $id ) {
		
		if ( !$mosque = $this->mosqueRepo->findById( $id ) ) {
			return redirect( route( 'admin.mosque.manage' ) )->with( 'error', 'Unable to find requested Mosque.' );
		}

        $selectedMosqueUsers = array();
		foreach ($mosque->users as $user) {
		    $selectedMosqueUsers[] = $user->id;
		}
				
		$action = 'edit';
		$allMosqueUsers = $this->userRepo->getMosqueUserList();
		$states = $this->stateRepo->getStates(true);
		toolbox()->pluginsManager()->plugins(['bs-daterangepicker-2.0', 'chosen']);
		return view(
			toolbox()->backend()->view( 'mosque.edit' ),
			compact( 'action', 'mosque', 'allMosqueUsers', 'selectedMosqueUsers','states')
		);
	}

	/**
	 * Update record
	 *
	 * @param MosqueCreateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( MosqueUpdateRequest $request ) {

		$data = $request->except( ['_token'] );
		if ( !$mosque = $this->mosqueRepo->update( $request->id, $data) ) {
			return redirect()->back()->with( 'error', $this->mosqueRepo->getErrorMessage() );
		}

		$this->userMosqueRepo->delete($request->id);

		foreach ($request->user_id as $key => $value) {
			$mosque = $this->userMosqueRepo->assignToUser($value, $request->id );
		}

		return redirect( route( 'admin.mosque.manage' ) )->with( 'success', $this->mosqueRepo->getMessage() );
	}

	/**
	 * View
	 *
	 * @param $id
	 * @param JobLocationsDataTable $dataTable
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function view($id, JobLocationsDataTable $dataTable) {
		
		if(!$job = $this->mosqueRepo->findById($id)) {
			return redirect(route('admin.mosque.manage'))->with('error', 'Unable to find requested job.');
		}
		
		$action = 'view';
		$locations = $this->jobLocationRepo->unlinkedLocations( $id );
		toolbox()->pluginsManager()->plugins(['datatables']);
		
		return $dataTable->render(toolbox()->backend()->view('mosque.view'), compact('action', 'id', 'job', 'locations'));
	}
	
	/**
	 * An XHTTPRequest call
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function importHomeOwners(Request $request) {
		
		if(!$job = $this->mosqueRepo->findById($request->job_id)) {
			return redirect(route('admin.mosque.view', $request->job_id))->with('error', 'Requested job is not available.');
		}
		
		if(!$request->locations || !is_array($request->locations)) {
			return redirect(route('admin.mosque.view', $request->job_id))->with('error', 'No location has selected.');
		}
		
		foreach($request->locations as $location) {
			if(JobLocation::whereJobId($request->job_id)->whereLocationId($location)->count()) {
				continue;
			}
			JobLocation::create(['job_id' => $request->job_id, 'location_id' => $location]);
		}
		
		repo()->activity()
			->action('import', 'imported homeowners in')
			->item('drive', $job->id, $job->name)
			->add();
		
		return redirect(route('admin.mosque.view', $request->job_id))->with('success', 'Homeowners are imported in current job.');
		
	}
	
	/**
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Exception
	 */
	public function completed(Request $request) {
		
		if( !$this->mosqueRepo->markCompleted($request->job_id) ) {
			return toolbox()->response()
				->error( $this->mosqueRepo->getErrorMessage() )
				->send();
		}
		
		return toolbox()->response()
			->success($this->mosqueRepo->getMessage(), ['location' => route('admin.mosque.view', $request->job_id) ])
			->send();
		}

}

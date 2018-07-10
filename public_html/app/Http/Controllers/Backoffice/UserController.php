<?php

namespace App\Http\Controllers\Backoffice;

use App\DataTables\Backoffice\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\UserCreateRequest;
use App\Http\Requests\Backoffice\UserUpdateRequest;
use App\Models\Repositories\Eloquent\RoleRepository;
use App\Models\Repositories\Eloquent\UserLocationRepository;
use App\Models\Repositories\Eloquent\UserRepository;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{

	protected $userRepo, $roleRepo, $avatarStoragePath;

	public function __construct( UserRepository $userRepository, RoleRepository $roleRepository) {
		$this->userRepo = $userRepository;
		$this->roleRepo = $roleRepository;
		$this->avatarStoragePath = $this->userRepo->getModel()->getAvatarStoragePath();
	}

	/**
	 * Manage
	 *
	 * @param UsersDataTable $dataTable
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function manage( UsersDataTable $dataTable ) {
		$notifications = $this->userRepo->getNotConfirmedUser();
		toolbox()->pluginsManager()->plugins(['datatables']);
		return $dataTable->render( toolbox()->backend()->view( 'users.manage' ) , compact('notifications'));
	}

	/**
	 * Change status to active or inactive
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function block( Request $request ) {
		if ( !$user = $this->userRepo->changeStatus( $request->id, $request->status ) ) {
			return toolbox()->response()->error( $this->userRepo->getErrorMessage() )->send();
		}

		return toolbox()->response()->success( $this->userRepo->getMessage() )->send();
	}

	/**
	 * Confirm user
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function confirm( Request $request ) {

		if ( !$user = $this->userRepo->confirmById( $request->id ) ) {
			return toolbox()->response()->error( $this->userRepo->getErrorMessage() )->send();
		}

		return toolbox()->response()->success( $this->userRepo->getMessage() )->send();
	}

	/**
	 * Delete user
	 *
	 * @param $userId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete( $userId ) {
		if ( !$user = $this->userRepo->delete( $userId ) ) {
			return redirect( route( 'admin.users.manage' ) )->with( 'error', $this->userRepo->getErrorMessage() );
		}

		return redirect( route( 'admin.users.manage' ) )->with( 'success', $this->userRepo->getMessage() );
	}

	/**
	 * Create
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {

		$action = 'create a new';
		$roles = $this->roleRepo->getActiveRolesList( Role::TYPE_ADMIN );
		$notifications = $this->userRepo->getNotConfirmedUser();

		return view( toolbox()->backend()->view( 'users.edit' ), compact( 'action', 'roles' , 'notifications') );
	}

	/**
	 * Store new user
	 *
	 * @param UserCreateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( UserCreateRequest $request ) {

		$data = $request->except( ['_token', 'avatar'] );
		if ( !$user = $this->userRepo->create( $data, $request->avatar ) ) {
			return redirect( route( 'admin.users.manage' ) )->with( 'error', $this->userRepo->getErrorMessage() );
		}

		return redirect( route( 'admin.users.manage' ) )->with( 'success', $this->userRepo->getMessage() );
	}

	/**
	 * Edit View
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function edit( $id ) {
		if ( !$user = $this->userRepo->findById( $id ) ) {
			return redirect( route( 'admin.users.manage' ) )->with( 'error', 'Unable to find requested user.' );
		}

		$action = 'edit';
		$roles = $this->roleRepo->getActiveRolesList( Role::TYPE_ADMIN );
		$notifications = $this->userRepo->getNotConfirmedUser();

		return view( toolbox()->backend()->view( 'users.edit' ), compact( 'action', 'id', 'user', 'roles','notifications' ) );
	}

	/**
	 * Update record
	 *
	 * @param UserUpdateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( UserUpdateRequest $request ) {

		$data = $request->except( ['_token', 'avatar' ] );
		if ( !$user = $this->userRepo->update( $request->id, $data, $request->avatar ) ) {
			return redirect( route( 'admin.users.manage' ) )->with( 'error', $this->userRepo->getErrorMessage() );
		}

		return redirect( route( 'admin.users.manage' ) )->with( 'success', $this->userRepo->getMessage() );
	}
	
	/**
	 * @param string $fieldName
	 * @return array
	 */
	public function apiHomeownersList( $fieldName ) {
		$homeowners = $this->userRepo->getHomeownersList(true, $fieldName, request()->query('term'));
		$output = [];
		foreach($homeowners as $id => $text) {
			$output[] = ['id' => $id, 'text' => $text];
		}
		
		return ['results' => $output];
	}
	
	/**
	 * @param string $fieldName
	 * @return array
	 */
	public function apiLocationsList($fieldName) {
		
		$homeowners = $this->locationRepo->getLocationsList(true, $fieldName, request()->query('term'));
		$output = [];
		foreach($homeowners as $id => $text) {
			$output[] = ['id' => $id, 'text' => $text];
		}
		
		return ['results' => $output];
	}
}

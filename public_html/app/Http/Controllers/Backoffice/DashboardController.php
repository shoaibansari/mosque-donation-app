<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use App\Models\MosqueDonation;
use App\Models\Repositories\Eloquent\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller {
	protected $userRepo ;
	
	/**
	 * DashboardController constructor.
	 * @param UserRepository $userRepository
	 * @param JobRepository $jobRepo
	 * @param ActivityRepository $activityRepo
	 */
	public function __construct( UserRepository $userRepository) {
		$this->userRepo = $userRepository;
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	//public function index(DashboardBacklogJobsDataTable $backlogJobs, DashboardAvailableJobsDataTable $availableJobs) {
	public function index() {
		 
		$mosques = Mosque::count();
		$mosque_admin = User::where('user_type', 2)->get()->count();
		$donors = MosqueDonation::count();
		$funds = new MosqueDonation; 
		$TotalFunds = $funds->sum('payment');
		$TotalFunds = number_format($TotalFunds);
 		toolbox()->pluginsManager()->plugins(['bs-table']);
		return view( toolbox()->backend()->view( 'dashboard'), compact('mosques', 'mosque_admin', 
			'donors', 'TotalFunds'));
	}
}

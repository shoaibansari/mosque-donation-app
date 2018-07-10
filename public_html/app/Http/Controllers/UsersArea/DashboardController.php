<?php

namespace App\Http\Controllers\UsersArea;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\User;
use App\Models\Mosque;
use Carbon\Carbon;
use App\Models\Repositories\Eloquent\UserRepository;
use App\Models\Repositories\Eloquent\DonationRepository;
class DashboardController extends Controller
{
    protected $userRepo , $donationRepo;
    /**
     * Create a new controller instance.
     *
     */
    public function __construct( UserRepository $userRepository , DonationRepository $donationRepository)
    {
      $this->userRepo = $userRepository;
      $this->donationRepo = $donationRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //$admin = repo()->user()->getLogginedUser();
       /* $mosque_admin_id = \Auth::id() ; 
        $visitDate = $this->userRepo->saveTime($mosque_admin_id );*/
        $mosque_admin_id = \Auth::id() ; 
        $visitDate = $this->userRepo->getVisitDate($mosque_admin_id);
        

        $notifications = $this->donationRepo->getLatestDonation($visitDate);
       /* $data = Donation::where('user_id', '=', $mosque_admin_id)
        ->where('is_active' , '=' , 1)
        ->where('end_date' , '>=' , Carbon::now() )
        ->orderBy('id', 'DSC')
        ->get();*/
        $data = $this->donationRepo->getUserDonationMosque( $mosque_admin_id );
        /*echo "<pre>"; print_r($data); die; */
        $mosque = new Mosque();

        /*$user_name = User::where('id', '=', $data->user_id)->pluck('name');
        $mosque_name = Mosque::where('id', '=', $data->mosque_id)->pluck('mosque_name');*/
        return view(toolbox()->userArea()->view('dashboard') , compact('data','user','mosque','notifications') );
    }
}

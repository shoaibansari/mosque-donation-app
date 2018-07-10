<?php
namespace App\Models\Repositories\Eloquent;

use Carbon\Carbon;
use App\Models\Repositories\DonationRepositoryInterface;
use App\Models\User;
use App\Models\Donation;
use App\Models\MosqueDonation;
use Illuminate\Support\Facades\DB;

class DonationRepository extends AbstractRepository implements DonationRepositoryInterface
{
	/**
	 * DonationRepository constructor.
	 * @param User $users
	 */
    public function __construct( Donation $donations ) {
    	parent::__construct( $donations );
        $this->model   = $donations;
    }

    /**
	 * @param bool $new
	 * @param array $attributes
	 * @return DonationRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new DonationRepository( (new Donation($attributes)) );
		}

		return $instance;
	}

	 public function create( $data ) {

		if(!$donations = $this->add($data)) {
			return $this->setErrorMessage('Unable to create Mosque Donation.');
		}
			$this->setMessage('The Mosque Donation has been created.');
		return $donations;
	}
    
    /**
	 * @param $data
	 * @throws \Exception
	 */
    private function add($data){

	   	$data['start_date'] = ( date( 'Y-m-d' , strtotime( $data['start_date'] ) ) );
	   	$data['end_date'] = ( date( 'Y-m-d' , strtotime( $data['end_date'] ) ) );
	   	
	   	if(auth('admin')->user()){
             $data['user_id'] = auth('admin')->user()->id;
	   	}else{
	   		$data['user_id'] = auth()->user()->id;
	   	}
	   	
	   	
		  if( !$donation = $this->model->create($data) ){
		   return $this->setMessage('Donation could not created');
		  }

		  $this->setData('success', 'Congratulation! Donation has been created.');
		  $this->setData('details', '');
		  $this->setMessage($donation->donation_title . ' has been added.');
		  
		  return $donation;

	}


	/**
	 * @param $donationId
	 * @param $data
	 * @throws \Exception
	 */
	public function update($donationId, $data) {

		if(!$donation = $this->findById($donationId)) {
			return $this->setErrorMessage('Unable to find requested donation.');
		}

		$data = array_except($data, ['_token']);

		$donation->update($data);

		$this->setMessage('The donation has been updated.');
		
		return $donation;
	}

	/**
	 * Delete a donation
	 *
	 * @param $donationId
	 * @return bool
	 * @throws \Exception
	 */
	public function delete($donationId) {
		
		if(!$donation = $this->getModel($donationId)) {
			return $this->setErrorMessage('Unable to find requested donation.');
		}
     
		// removing donation
		$donation->delete();			
	
		return $this->setMessage('Mosque has been deleted.');
	}
    

    public function getDonationMosque($mosqueId)
    {    
        $donation = DB::select("SELECT id, mosque_id, donation_title, donation_description, required_amount, start_date, end_date, (SELECT SUM(funds.payment) FROM funds WHERE donation_id = donations.id) as total_fund FROM `donations`where is_active = 1 and end_date >= '".Carbon::now()->format('Y-m-d')."' and mosque_id=".$mosqueId);

		return $donation;			
    }

    public function getUserDonationMosque($user_id){
    	return $this->model->where('user_id', '=', $user_id)
        ->where('is_active' , '=' , 1)
        ->where('end_date' , '>=' , Carbon::now() )
        ->orderBy('id', 'DSC')
        ->get();

    }

    public function getLatestDonation($date){

    	$data['count'] = $this->model->where('created_at', '>=' , $date)->count();
    	$data['notification'] = $this->model->where('created_at', '>' , $date)->get();
    	return $data;
    }




}
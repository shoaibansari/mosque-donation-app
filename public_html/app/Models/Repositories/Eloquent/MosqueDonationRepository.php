<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Mosque;
use App\Models\MosqueDonation;
use App\Models\Repositories\MosqueDonationRepositoryInterface;
use Carbon\Carbon;
use DB;

class MosqueDonationRepository extends AbstractRepository implements MosqueDonationRepositoryInterface {

    public function __construct(MosqueDonation $mosqueDonation) {
        parent::__construct( $mosqueDonation );
    }

    /**
     * @param bool $new
     * @param array $attributes
     * @return MosqueRepository
     */
    public static function instance( $new = false, $attributes = [] ) {
        static $instance = null;
        if ( is_null( $instance ) || $new ) {
            $instance = new MosqueDonationRepository( (new MosqueDonation($attributes)) );
        }

        return $instance;
    }

    /**
     * @param $data
     * @param null $mosque_id
     * @return bool|mixed
     * @throws \Exception
     */
    public function create( $data ) {

        // adding donation
        if(!$donation = $this->addRecord($data)) {
            return $this->setErrorMessage('Unable to receive a mosque donation.');
        }
        return $donation;
    }

    
    /**
     * get Donation detail
     *
     * @param $user_id
     * @param $donation_id
     * @throws \Exception
     */
    public function getDonationDetail( $donation_id ) {

        $donation = DB::table('funds')
                    ->select( 'donations.donation_title','mosques.mosque_name', 'funds.payment', 'funds.created_at', 'funds.updated_at')
                    ->join('users', 'users.id', '=', 'funds.user_id')
                    ->join('mosques', 'mosques.id', '=', 'funds.mosque_id')
                    ->join('donations', 'donations.id', '=', 'funds.donation_id')
                    ->where('funds.donation_id', $donation_id)
                    ->get();
                    
        if(count($donation) == 0) {
            return $this->setErrorMessage('Unable to find your donation.');
        }
        return $donation;
    }

    /**
     * get Past Donation
     *
     * @param $user_id
     * @param $donation_id
     * @throws \Exception
     */
    public function getPastDonationDetail( $user_id ){

        $pastDonation = DB::table('funds')
                    ->select('users.name', 'mosques.mosque_name','donations.donation_title', 'funds.payment', 'funds.created_at')
                    ->join('users', 'users.id', '=', 'funds.user_id')
                    ->join('mosques', 'mosques.id', '=', 'funds.mosque_id')
                    ->join('donations', 'donations.id', '=', 'funds.donation_id')
                    ->where('funds.user_id', $user_id)
                    ->get();
                    
         if(count($pastDonation) == 0) {
            return $this->setErrorMessage('Unable to find your past donation.');
        }

        return $pastDonation;
    }
   

    
}

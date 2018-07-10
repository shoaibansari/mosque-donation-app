<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Mosque;
use App\Models\User;
use App\Models\MosqueDonation;
use App\Models\Repositories\MosqueDonationRepositoryInterface;
use Carbon\Carbon;
use DB;
use Fpdf;
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
                ->select('users.name', 'mosques.mosque_name', 'funds.mosque_id', 'donations.donation_title', 'funds.payment', 'funds.payment_method', 'funds.created_at')
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

    public function getFundsByYear($user_id, $year){
         $user_funds = $this->model->where('user_id' , $user_id )->whereYear('created_at', '=', $year)->get();
       
        if(count( $user_funds ) > 0 ){
            $userData = User::find($user_id);
         
        Fpdf::AddPage();
        Fpdf::SetFont('Courier', 'B', 10);
        Fpdf::Header();

          Fpdf::Cell(50, 8, 'Email',0,0,'C');
          Fpdf::Cell(22, 8, 'Amount',0,0,'C');
          Fpdf::Cell(45, 8, 'Created At',0,0,'C');
        foreach ($user_funds as $value) {
          Fpdf::Ln();
          Fpdf::Cell(50, 8, $userData->email, 1 , 0 , 'C');
          Fpdf::Cell(22, 8, $value->payment,1, 0 , 'C');
          Fpdf::Cell(45, 8,$value->created_at,1, 0 , 'C');
            
        }

        //$fileName = $year.'-'.$userData->name.'.pdf';

        $fileName = $year.'-'.$userData->name.'.pdf';
        $pdfFile = tempnam(sys_get_temp_dir(), $fileName);
        dd($pdfFile);
       

        Fpdf::Output('F', $pdfFile);


        //dd($value->email);
            toolbox()->email()
                ->fromNoReply()
                ->to( $userData->email, $userData->name )
                ->subject( 'Funds Summary of '. $year)
                ->message(
                    toolbox()->frontend()->view( 'emails.funds-summery' ), [
                    'userName'         => $userData->name ,
                   
                ])
                ->attach(public_path( $fileName ) , [
                    'as' => $fileName, 
                    'mime' => 'application/pdf'
                 ])
                ->send();
        
         return $user_funds;
        }else{
            return false;
        }

         
        //$this->setData('details', 'Please click on the link that has just been sent to your email address to verify your email account to complete your registration.');
    }

    
}

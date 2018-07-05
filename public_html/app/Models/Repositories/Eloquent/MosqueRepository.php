<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Mosque;
use App\Models\Repositories\MosqueRepositoryInterface;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserMosque;
use DB;

class MosqueRepository extends AbstractRepository implements MosqueRepositoryInterface {
	
	public function __construct(Mosque $mosque, UserDevice $deviceRepo) {
		parent::__construct( $mosque );

        $this->deviceRepo = $deviceRepo;
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return MosqueRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new MosqueRepository( (new Mosque($attributes)) );
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

		// adding mosque
		if(!$mosque = $this->addRecord($data)) {
			return $this->setErrorMessage('Unable to create a mosque.');
		}
						
		$this->setMessage('The mosque has been created.');
		return $mosque;
	}

	/**
	 * @param $mosqueId
	 * @param $data
	 * @param null $user_id
	 * @return bool|mosqueLocation
	 * @throws \Exception
	 */
	public function update($mosqueId, $data, $user_id=null) {

		if(!$mosque = $this->findById($mosqueId)) {
			return $this->setErrorMessage('Unable to find requested drive.');
		}

		$data = array_except($data, ['_token']);

		$mosque->update($data);

		$this->setMessage('The mosque has been updated.');
		
		return $mosque;
	}

	/**
	 * Delete a drive/mosque
	 *
	 * @param $mosqueId
	 * @return bool
	 * @throws \Exception
	 */
	public function delete($mosqueId) {
		
		if(!$mosque = $this->getModel($mosqueId)) {
			return $this->setErrorMessage('Unable to find requested record.');
		}
          $mosque->users()->sync([]);
     
		// removing mosque
		$mosque->delete();			
	
		return $this->setMessage('Mosque has been deleted.');
	}
    
    public function checkNearByMosque($latitude,$longitude){

        $check_mosque = Mosque::where('is_active', 1)->select(DB::raw('*, ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
		    ->having('distance', '<', 25)
		    ->orderBy('distance')
		    ->get();

        if(count($check_mosque) == 0){
           return $this->setErrorMessage('Unable mosque.');	
        }
     
        return $check_mosque;
    }


    /**
	 * Get mosque list
	 *
	 * @param int $active
	 * @return mixed
	 */
	public function getMosqueList($empty=false) {
		$mosque = Mosque::all()->pluck('mosque_name','id');

		if(!$empty){
			return $mosque;			
		}

		$a = [];
		$a[''] = '';
		foreach ($mosque as $key => $value) {
		 	$a[$key] = $value;
		 } 

		return $a;
	}

	/**
	 * Get User list
	 *
	 * @param int $active
	 * @return mixed
	 */
	public function getUserList($empty=false) {
		$user = User::where( 'user_type', Role::TYPE_MOSQUE_ADMIN )
		->get()
		->pluck('name','id');

		if(!$empty){
			return $user;			
		}

		$a = [];
		$a[''] = '';
		foreach ($user as $key => $value) {
		 	$a[$key] = $value;
		 } 

		return $a;
	}
    
	
	
}

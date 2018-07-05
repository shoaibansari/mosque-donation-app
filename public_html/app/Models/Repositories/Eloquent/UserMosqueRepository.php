<?php

namespace App\Models\Repositories\Eloquent;
use App\Models\Repositories\UserMosqueRepositoryInterface;
use App\Models\UserMosque;

class UserMosqueRepository extends AbstractRepository implements UserMosqueRepositoryInterface {
	
	public function __construct(UserMosque $userMosque) {
		parent::__construct( $userMosque );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return UserMosqueRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new UserMosqueRepository( (new UserMosque($attributes)) );
		}

		return $instance;
	}
	
	
	/**
	 * @param $data
	 * @param null $mosque_id
	 * @return bool|mixed
	 * @throws \Exception
	 */
	public function create( $userId, $mosqueId ) {

		// adding mosque
		if(!$mosque = $this->addRecord(['user_id' => $userId, 'mosque_id' => $mosqueId])) {
			return $this->setErrorMessage('Unable to create a mosque.');
		}
						
		$this->setMessage('The mosque assign has been successfully.');
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
		
		$mosque->update($data)->withMosques();
		
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
        $mosque = $this->getModel()->where('mosque_id', $mosqueId);
		$mosque->delete();

		if(empty($mosqueId)){
          return true;
		}else{
			return false;
		}
		
	}
	

	public function assignToUser($userId,$mosqueId){		

		if(!$user_mosque = $this->create($userId, $mosqueId)) {
			return $this->setErrorMessage('Unable to create a mosque.');
		}

		return $user_mosque;
	}

	/**
	 * Check user of mosque
	 *
	 * @param $mosqueId
	 * @return $userId
	 * @throws \Exception
	 */
	public function checkMosqueUser($mosqueId){		

		$check_user_mosque = UserMosque::where('mosque_id', $mosqueId)
            ->where('user_id', auth()->user()->id)->exists();
        
        if(!$check_user_mosque){
           return $this->setErrorMessage('Unable user of this mosque.');	
        }

        return $check_user_mosque;
	}



}

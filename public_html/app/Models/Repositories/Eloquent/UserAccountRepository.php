<?php 

namespace App\Models\Repositories\Eloquent;

use App\Models\Repositories\UserAccountRepositoryInterface;
use App\Models\UserAccount;

class UserAccountRepository extends AbstractRepository implements UserAccountRepositoryInterface { 

	public function __construct( UserAccount $userAccount ) {
		parent::__construct( $userAccount );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return UserAccountRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new UserAccountRepository( (new UserAccount($attributes)) );
		}

		return $instance;
	}

	/**
	 * @param $data
	 * @throws \Exception
	 */
	public function create( $data ) {

		// add wallet
		if(!$userAccount = $this->addRecord($data)) {
			return $this->setErrorMessage('Unable to create wallet.');
		}
						
		$this->setMessage('The wallet has been created.');
		return $userAccount;
	}
}
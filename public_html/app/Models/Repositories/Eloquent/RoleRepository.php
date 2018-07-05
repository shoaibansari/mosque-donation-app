<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 12/18/2017 12:47 PM
 */

namespace App\Models\Repositories\Eloquent;

use App\Models\Permission;
use App\Models\Repositories\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface {

	/**
	 * PageRepository constructor.
	 * @param Role $role
	 */
	public function __construct( Role $role ) {
		parent::__construct( $role );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return RoleRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$role = new Role( $attributes );
			$instance = new RoleRepository( $role );
		}

		return $instance;
	}

	/**
	 * Get listing
	 *
	 * @param bool $plain
	 * @param bool $array
	 * @return mixed
	 */
	public function getAllActive( $plain = false, $array = false ) {
		if ( $plain ) {
			if ( $array ) {
				return $this->getModel()->select( 'id', 'title' )->active()->get()->toArray();
			}
			else {
				return @json_decode( $this->getModel()->select( 'id', 'title' )->active()->get()->toJson() );
			}
		}

		return $result = $this->getModel()->active()->get();
	}

	/**
	 * Get data for list-box
	 *
	 * @param null $except
	 * @return array
	 */
	public function getActiveRolesList( $except=null ) {

		if ( !$data = Role::select( 'id', 'title' )->active()->get() ) {
			return [];
		}

		$output = [];
		foreach ( $data as $item ) {
			if ( is_array($except) ) {
				$allow=true;
				foreach( $except as $eid ) {
					if ( $eid == $except ) {
						$allow=false;
						break;
					}
				}
				if ( !$allow )
					continue;
			}
			else if ( !is_null( $except ) ) {
				if ( $item->id == $except ) {
					continue;
				}
			}
			$output[ $item->id ] = $item->title;
		}

		return $output;
	}

	/**
	 * Get data for list box
	 *
	 * @return array
	 */
	public function getActivePermissionsList() {

		if ( !$data = Permission::select('id', 'title')->active()->get() ) {
			return [];
		}

		$output = [];
		foreach ( $data as $item ) {
			$output[ $item->id ] = $item->title;
		}

		return $output;
	}

}
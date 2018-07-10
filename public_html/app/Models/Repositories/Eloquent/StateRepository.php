<?php

namespace App\Models\Repositories\Eloquent;

use App\Models\Repositories\StateRepositoryInterface;
use App\Models\State;

class StateRepository extends AbstractRepository implements StateRepositoryInterface {

	public function __construct( State $state ) {
		parent::__construct( $state );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return StateRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$instance = new StateRepository( (new State($attributes)) );
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
	public function getAllActive( $plain=false, $array=false ) {
		if ( $plain ) {
			if ( $array ) {
				return $this->getModel()->select( 'id', 'name', 'code' )->active()->get()->toArray();
			}
			else {
				return @json_decode( $this->getModel()->select( 'id', 'name', 'code' )->active()->get()->toJson() );
			}
		}
		return $result = $this->getModel()->active()->get();
	}

	 public function getStates($withEmpty=false) {
        $allCats = $this->model->active()->orderBy('id','asc')->pluck('name', 'code')->toArray();

        if (!$withEmpty) {
            return $allCats;
        }

        $categories = [];
        $categories[0] = 'Select Category';
        foreach ($allCats as $key => $value) {
            $categories[$key] = $value;
        }
    	return $categories;
    }

	/**
	 * Get data for list box
	 *
	 * @return array
	 */
	public function getActiveList() {
		if ( !$data = $this->getAllActive( true ) ) {
			return [];
		}

		$output = [];
		foreach( $data as $item ) {
			$output[ $item->code ] = $item->name;
		}
		return $output;
	}

	public function getStateByCode( $code ) {
		$state = $this->model->where( 'code', $code )->first();
		if ( !$state ) {
			return false;
		}
		return $state;
	}

	public function getIdByCode( $code ) {
		$state = $this->getStateByCode( $code );
		if ( !$state ) {
			return false;
		}

		return $state->id;
	}


}

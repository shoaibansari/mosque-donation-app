<?php
namespace App\Models\Repositories\Eloquent;

use App\Models\Repositories\SliderRepositoryInterface;
use App\Models\Slider;

class SliderRepository extends AbstractRepository implements SliderRepositoryInterface {

	/**
	 * SliderRepository constructor.
	 * @param Slider $slider
	 */
	public function __construct( Slider $slider ) {
		parent::__construct( $slider );
		$this->model = $slider;
	}

}
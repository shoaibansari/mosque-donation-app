<?php
namespace App\Models\Repositories\Eloquent;

use App\Models\Repositories\SliderRepositoryInterface;
use App\Models\Slider;

class SlideRepository extends AbstractRepository implements SliderRepositoryInterface {


	/**
	 * SlideRepository constructor.
	 * @param Slider $slider
	 */
	public function __construct( Slider $slider ) {
		parent::__construct( $slider );
	}

}
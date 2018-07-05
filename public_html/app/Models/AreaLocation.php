<?php

namespace App\Models;

use App\Models\Repositories\Eloquent\AreaLocationRepository;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AreaLocation extends Model {

	protected $fillable = [
		'area_id',
		'location_id',
	];

	public function __construct( array $attributes = [] ) {
		parent::__construct( $attributes );
	}

	public function area() {
		return $this->belongsTo( Area::class );
	}

	public function location() {
		return $this->belongsTo( UserLocation::class, 'location_id', 'id');
	}


}

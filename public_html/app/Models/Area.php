<?php

namespace App\Models;

use App\Models\Repositories\Eloquent\AreaRepository;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Area extends Model {


	protected $fillable = [
		'title',
		'active',
		'created_at',
		'updated_at',
		'creator_id'
	];


	public function __construct( array $attributes = [] ) {
		parent::__construct( $attributes );
	}

	public function creator() {
		return $this->hasOne( User::class, 'id', 'creator_id');
	}

	public function locations() {
		return $this->belongsToMany( UserLocation::class, 'area_locations', 'area_id', 'location_id');
	}

	public function jobs() {
		return $this->hasMany( Job::class );
	}

	public function scopeActive( $query ) {
		return $query->whereActive( 1 );
	}

}

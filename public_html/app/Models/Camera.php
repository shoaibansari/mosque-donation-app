<?php

namespace App\Models;

use App\Models\Repositories\Eloquent\CameraRepository;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Camera extends Model {
	
	protected $table = 'driver_camera';

	protected $fillable = [
		'name',
		'dpi',
		'size',
		'images_per_second',
		'check_connection_after',
		'created_at',
		'updated_at',
		'driver_id',
		'active'
	];


	public function __construct( array $attributes = [] ) {
		parent::__construct( $attributes );
		
	}
	
	public function scopeActive($query) {
		return $query->whereActive(1);
	}
	
	public function driver() {
		return $this->belongsTo(Driver::class);
	}

}

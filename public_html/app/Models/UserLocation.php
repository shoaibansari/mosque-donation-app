<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLocation extends Model {

	use SoftDeletes;

	protected $fillable = [
		'homeowner_id', 'address', 'street', 'city', 'state', 'zip', ' country', 'is_approved', 'latitude', 'longitude'
	];
	
	public function homeOwner() {
		return $this->belongsTo( User::class, 'homeowner_id', 'id');
	}

	public function photos() {
		return $this->hasMany( LocationPhoto::class, 'location_id', 'id' );
	}
	
	public function areas() {
		return $this->belongsToMany( Area::class, 'area_locations', 'location_id', 'area_id');
	}

	public function scopePending( $query ) {
		$query->where( 'is_approved', -1 );
	}

	public function scopeApproved( $query ) {
		$query->where( 'is_approved', 1 );
	}

	public function scopeRejected( $query ) {
		$query->where( 'is_approved', 0 );
	}
	
	public function scopeConfirmationStatus( $query, $status ) {
		$query->where('is_confirmed', $status);
	}
	
	public function isPending() {
		return $this->is_approved == -1;
	}
	
	public function isRejected() {
		return $this->is_approved == 0;
	}
	
	public function isApproved() {
		return $this->is_approved == 1;
	}

	public function status() {
		switch ( $this->is_approved ) {
			case -1:
				return 'Pending';
			case 1:
				return 'Approved';
			default:
				return 'Rejected';
		}
	}



}

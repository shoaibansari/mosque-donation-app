<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	const CAN_UPLOAD_PHOTOS = 1;
	const CAN_REMOVE_PHOTOS = 2;
	const CAN_REPORT_VIOLATIONS = 3;
	const CAN_SEE_VIOLATION_DETAILS = 4;
	
	
    public function scopeActive( $query ) {
    	return $query->where('active', 1);
    }
}

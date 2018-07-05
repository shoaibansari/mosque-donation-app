<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

	const TYPE_HEADER = 1;
	const TYPE_FOOTER = 2;
	const TYPE_SIDEBAR = 3;
	const TYPE_SERVICES = 4;

	public function items() {
		return $this->hasMany( MenuItem::class );
	}

	public function scopeActive( $query ) {
		return $query->where('active', 1);
	}

}

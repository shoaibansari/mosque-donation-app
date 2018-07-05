<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

	protected $fillable = ['id', 'title', 'active'];
	
	public function scopeActive( $query ) {
		return $query->whereActive(1);
	}
}

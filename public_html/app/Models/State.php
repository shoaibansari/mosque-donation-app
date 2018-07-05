<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model {

	protected $fillable = ['id', 'name', 'code'];
	
	public function scopeActive( $query ) {
		return $query->whereActive(1);
	}
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model {

	protected $fillable = ['user_id'];

	public function info() {
		return $this->belongsTo( User::class, 'id' );
	}
	
	// public function jobs() {
	// 	return $this->belongsToMany(Job::class);
	// }

}

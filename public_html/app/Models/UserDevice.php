<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model {
	
	protected $fillable = [
		'user_id', 'token', 'platform', 'os_version', 'device_id', 'gcm_id', 'notifications', 'badges', 'latitude', 'longitude',
		'last_activity_at'
	];
	
	public function user() {
		return $this->belongsTo( User::class );
	}
	
}

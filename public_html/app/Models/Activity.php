<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {
	
	const ACTION_CREATE = 'created';
	const ACTION_CHANGE = 'changes';
	const ACTION_DELETE = 'removed';
	

	protected $fillable = ['module', 'action', 'user_id', 'user_name', 'details'];
	
	public function user() {
		return $this->belongsTo( User::class );
	}
	
}

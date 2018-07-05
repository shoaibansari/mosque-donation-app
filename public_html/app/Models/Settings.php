<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {

	protected $fillable = [
		'id', 'type', 'label', 'key', 'value', 'default_value', 'editable', 'visible', 'display_order'
	];

	protected $hidden = [ 'created_at', 'updated_at', 'deleted_at'];

	public function scopeVisible( $query ) {
		return $query->where('visible', 1);
	}

} // end of class

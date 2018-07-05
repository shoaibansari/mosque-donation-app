<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model {

	protected $fillable = [
		'user_id',
		'mosque_id',
		'donation_title',
		'donation_description',
		'required_amount',
		'start_date',
		'end_date',
		'is_active'
	];
    
    public function scopeActive($query) {
        return $query->whereIsActive(1);
    }

}

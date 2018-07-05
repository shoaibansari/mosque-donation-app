<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
	protected $fillable = [
		'user_id',
		'payment_method',
		'paypal_email'
	];

	public function user() {
		return $this->belongsTo( User::class );
	}
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{

	protected $fillable = [
		'mosque_name',
		'authorized_name',
		'email',
        'paypal_email',
		'address',
		'zip_code',
		'phone',
		'bank_account',
		'tax_id',
        'is_active',
        'longitude',
        'latitude'
	];

	public function __construct( array $attributes = [] ) {
		parent::__construct( $attributes );
		
	}

    public function users() {
        return $this->belongsToMany( User::class, 'user_mosques' );
    }

    public function mosqueDoantions() {
        return $this->belongsTo( MosqueDonation::class, 'mosque_donations' );
    }

    public function scopeActive($query) {
        return $query->whereIsActive(1);
    }

}

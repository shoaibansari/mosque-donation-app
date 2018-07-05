<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['category_id', 'email', 'active', 'optout'];

	public function scopeActive( $query ) {
    	return $query->where('active', 1);
    }

    public function scopeOptIn( $query ) {
    	return $query->where('optout', 0);
    }

	public function scopeOptOut( $query ) {
		return $query->where( 'optout', 1 );
	}
}

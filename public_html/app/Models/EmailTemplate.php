<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    const FORGOT_PASSWORD = 1;
    const CONTACT_US = 2;
    const ENQUIRY_FORM = 3;

	public function getTagsAttribute( $tags ) {
		if ( !$tags )
			return null;

		return array_map('strtoupper',array_map( 'trim', explode( '|', $tags)));
	}

}

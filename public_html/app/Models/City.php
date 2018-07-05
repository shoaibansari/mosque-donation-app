<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model {

	public static function searchByCountryId( $country_id, $city, $limit=10 ) {
		return self::select('name')
		           ->where('country_code', Country::find($country_id)->code)
		           ->where('name', 'like', '%'.$city.'%')
		           ->take($limit)
		           ->get();

	}

	public static function findByCountryId( $country_id, $city ) {
		$country_code = Country::find($country_id)->code;
		return self::where('country_code', $country_code)
		           ->where('name', $city)
			->take(1)
			->first();
	}

	public static function exists( $country_id, $city ) {
		return self::findByCountryId( $country_id, $city) ? true : false;
	}

}

<?php

namespace App\Http\Requests\UsersArea;

use Illuminate\Foundation\Http\FormRequest;

class MosqueCreateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
	    
        $longitude = 'required_if:address,""';
        if(request('longitude') == '') {
            $longitude .= 'required';
        }
        $latitude = 'required_if:address,""';
        if(request('latitude') == '') {
            $latitude .= 'required';
        }


		return [
			'mosque_name'            => 'required',
			'authorized_name'        => 'required',
            'paypal_email'           => 'required|email',
			'address'                => 'required|min:10|max:100',
			'zip_code'               => 'required|integer',
			'phone'                  => 'required|min:7|max:11',
			'bank_account'           => 'required|min:10',
			'tax_id'                 => 'required|min:14|integer',
            'longitude'              => $longitude,
            'latitude'               => $latitude,

		];
	}

	public function attributes() {
		return [
			'mosque_name'            => 'Mosque Name',
			'authorized_name'        => 'Authorized Representative Name',
            'paypal_email'           => 'PayPal Email',
			'address'                => 'Mosque Address',
			'zip_code'               => 'Zip Code',
			'phone'                  => 'Phone Number',
			'bank_account'           => 'Bank Account',
			'tax_id'                 => 'Tax ID',
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
}

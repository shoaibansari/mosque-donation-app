<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class MosqueCreateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
	    $password = 'required_if:user_id,""';
	    if (request('password') != '') {
	        $password .= '|min:8|max:40';
        }
        $user_id = 'required_if:password,""';
        if (request('user_id') != '') {
            $user_id .= '|min:1|max:2';
        }

        $user_email = 'required_if:email,""';
        if(request('user_id') == '') {
            $user_email .= 'required|email|unique:mosques,email|unique:users,email';
        }       
      
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
			'email'                  => $user_email.'|email',
            'paypal_email'           => 'required|email',
            'password'               => $password,
			'address'                => 'required|min:10|max:100',
			'zip_code'               => 'required',
			'phone'                  => 'required|min:7|max:11',
			'bank_account'           => 'required|min:20',
			'tax_id'                 => 'required|min:14',
			'user_id'                => $user_id,
            'is_active'              => 'required',
            'longitude'              => $longitude,
            'latitude'               => $latitude,
            'city'					=> 'required',
            'state'					=> 'required',
            'bank_routing'			=> 'required|min:14'	

		];
	}

	public function attributes() {
		return [
			'mosque_name'            => 'Mosque Name',
			'authorized_name'        => 'Authorized Representative Name',
			'email'                  => 'Email',
            'paypal_email'           => 'PayPal Email',
            'password'               => 'Password',
			'address'                => 'Mosque Address',
			'zip_code'               => 'Zip Code',
			'phone'                  => 'Phone Number',
			'bank_account'           => 'Bank Account',
			'tax_id'                 => 'Tax ID',
			'user_id'                => 'User Assign',
            'is_active'              => 'Active Mosque'
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

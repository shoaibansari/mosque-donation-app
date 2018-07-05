<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnquiryFormRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {

		$rules = [
			'name'                 => 'required|max:40',
			'phone'                => 'required|max:40',
			'email'                => 'required|email:100',
			'message'              => 'required|max:2000',
		];

		//$rules['g-recaptcha-response'] = 'required|recaptcha';

		return $rules;
	}

	public function attributes() {
		return [
			'name'                  => 'Name',
			'email'                 => 'Email Address',
			'phone'                 => 'Phone Number',
			'message'               => 'Message',
			'g-recaptcha-response'  => 'Security Code',
		];
	}
}

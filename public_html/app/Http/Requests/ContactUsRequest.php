<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest {
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
			'website'              => 'nullable|proper_url',
			'message'              => 'required|max:2000',
		    'form_type'            => 'required'
		];

		if (  strtolower(request('form_type')) == 'contact us' ) {
			$rules['g-recaptcha-response'] = 'required|recaptcha';
		}
		return $rules;
	}

	public function attributes() {
		return [
			'name'                  => 'Name',
			'email'                 => 'Email Address',
			'phone'                 => 'Phone Number',
			'website'               => 'Website',
			'message'               => 'Message',
			'g-recaptcha-response'  => 'Security Code',
		    'form_type'             => 'Form Type'
		];
	}
}

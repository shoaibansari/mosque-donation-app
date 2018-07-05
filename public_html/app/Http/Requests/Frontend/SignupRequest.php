<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name'                  => 'required|string|max:45',
			'email'                 => 'required|email|unique:users,email,' . request( 'id' ),
			'password'              => 'required|min:8|max:40',
			'password_confirmation' => 'required|same:password',
			'street'                => 'required',
			'city'                  => 'required',
			'state'                 => 'required',
			'zip'                   => 'required',
		];
	}

	public function attributes() {
		return [
			'name'                  => 'Name',
			'email'                 => 'Email',
			'password'              => 'Password',
			'password_confirmation' => 'Re-enter Password',
			'street'                => 'Street',
			'city'                  => 'City',
			'state'                 => 'State',
			'zip'                   => 'Zip',
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

<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'email'                 => 'required|email|exists:users',
			'password'              => 'required|min:8|max:40',
			'password_confirmation' => 'required|same:password',
		];
	}

	public function attributes() {
		return [
			'email'                 => 'Email',
			'password'              => 'Password',
			'password_confirmation' => 'Confirm Password',
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

<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name'                   => 'required|alpha',
			'email'                  => 'required|email|unique:users,email,' . request( 'id' ),
			'password'               => 'required|min:8|max:40',
			'password_confirmation'  => 'required|same:password',
            'phone'                  => 'required|max:11',
			'user_type'              => 'required',
			'roles'                  => 'required_if:is_administrative_user,1',
			'is_confirmed'           => 'required',
			'avatar'                 => 'image',
		];
	}

	public function attributes() {
		return [
			'name'                   => 'Name',
			'email'                  => 'Email',
			'password'               => 'Password',
			'password_confirmation'  => 'Re-enter Password',
            'phone'                  => 'Phone Number',
			'user_type'              => 'User Type',
			'roles'                  => 'Role',
			'is_confirmed'           => 'Confirmed User',
			'avatar'                 => 'Avatar',
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

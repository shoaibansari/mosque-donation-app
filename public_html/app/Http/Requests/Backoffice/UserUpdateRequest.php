<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$rules['name'] = 'required';
		$rules['email'] = 'required|email|unique:users,email,' . request( 'id' );
		if ( request('password') ) {
			$rules [ 'password' ] = 'min:4|max:40';
			$rules [ 'password_confirmation' ] = 'same:password';
		}

        $rules [ 'phone' ] = 'required';
		$rules [ 'user_type' ] = 'required';
		$rules [ 'roles' ] = 'required_if:is_administrative_user,1';
		$rules [ 'avatar' ] = 'nullable|image';

		return $rules;
	}

	public function attributes() {

		$attributes[ 'name' ] = 'Name';
		$attributes[ 'email' ] = 'Email';

		if ( request( 'password' ) ) {
			$attributes [ 'password' ] = 'Password';
			$attributes [ 'password_confirmation' ] = 'Re-enter Password';
		}
        $rules [ 'phone' ] = 'Phone Number';
		$rules [ 'user_type' ] = 'User Type';
		$attributes [ 'roles' ] = 'Role';
		$attributes [ 'avatar' ] = 'Avatar';

		return $attributes;
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

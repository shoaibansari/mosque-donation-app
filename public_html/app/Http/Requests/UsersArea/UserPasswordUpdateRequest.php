<?php

namespace App\Http\Requests\UsersArea;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordUpdateRequest extends FormRequest
{

	public function rules() {
		return [
			'current_password'      => 'required|min:8|max:40',
			'password'              => 'required|min:8|max:40|different:current_password',
			'password_confirmation' => 'required|same:password',
		];
	}


	public function attributes() {
		return [
			'current_password'   => 'Current Password',
			'password'  => 'New Password',
			'password_confirmation' => 'Retype New Password',
		];
	}

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

}

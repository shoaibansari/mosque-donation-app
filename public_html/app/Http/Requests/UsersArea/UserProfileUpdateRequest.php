<?php

namespace App\Http\Requests\UsersArea;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileUpdateRequest extends FormRequest
{

	public function rules() {
		return [
			'name'   => 'required|max:80',
			'email'  => 'required:max:120',
			'avatar' => 'image',
		];
	}


	public function attributes() {
		return [
			'name'   => 'Name',
			'email'  => 'Email Address',
			'avatar' => 'Avatar',
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

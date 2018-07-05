<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class AdminProfileUpdateRequest extends FormRequest
{

	public function rules() {
		return [
			'name'   => 'required|alpha|max:80',
			'email'  => 'required|email',
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

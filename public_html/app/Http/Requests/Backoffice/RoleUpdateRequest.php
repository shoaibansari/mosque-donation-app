<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'title'       => 'required|unique:roles,title,' . request('id'),
			'permissions' => 'required',
			'active'      => 'required',
		];
	}

	public function attributes() {
		return [
			'title'       => 'Title',
			'permissions' => 'Permissions',
			'active'      => 'Active',
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

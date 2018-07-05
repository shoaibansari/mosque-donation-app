<?php

namespace App\Http\Requests\UsersArea;
use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'address' => 'required',
			'street'  => 'required',
			'city'    => 'required',
			'state'   => 'required',
			'zip'     => 'required',
		];
	}
	
	public function attributes() {
		return [
			'address' => 'Address',
			'street'  => 'Street',
			'city'    => 'City',
			'state'   => 'State',
			'zip'     => 'Zip',
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

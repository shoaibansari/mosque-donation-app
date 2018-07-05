<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemCreateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		//dd( request()->toArray() );
		$rules = [
			'title' => 'required',
			'type'  => 'required',
		];

		if ( request('type') == 'slug' ) {
			$rules['page'] = 'required';
		} else {
			$rules[ 'url' ] = 'required|url';
		}

		return $rules;
	}

	public function attributes() {

		$attributes = [
			'title' => 'Title',
			'type'  => 'Link With',
			'page'  => 'Page',
			'url'   => 'URL'
		];

		if ( request( 'type' ) == 'slug' ) {
			$attributes[ 'page' ] = 'Page';
		}
		else {
			$attributes[ 'url' ] = 'URL';
		}

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

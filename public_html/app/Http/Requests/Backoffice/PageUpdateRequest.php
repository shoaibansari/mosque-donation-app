<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class PageUpdateRequest extends FormRequest
{
    /**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'heading'   => 'required',
			'contents'  => 'required',
			'banner'    => 'image',
			'published' => 'required',
		];
	}


	public function attributes() {
		return [
			'heading'   => 'Heading',
			'contents'  => 'Contents',
			'banner'    => 'Banner',
			'published' => 'Published',
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

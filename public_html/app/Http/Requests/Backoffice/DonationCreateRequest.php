<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class DonationCreateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'donation_title'        => 'required|regex:/(^[a-zA-Z ]+$)+/',		    
		    'required_amount'       => 'required|integer',
		    'start_date'            => 'required',
		    'end_date'              => 'required|after:start_date',
		    'mosque_id'             => 'required',
		    'is_active'             => 'required',
		    'donation_description'  => 'required|regex:/(^[a-zA-Z ]+$)+/|min:10|max:500'
		];
	}

	public function attributes() {
		return [
			'donation_title'         => 'Donation Title',
			'required_amount'        => 'Amount',
			'start_date'             => 'Start Date',
		    'end_date'               => 'End Date',
		    'mosque_id'              => 'Mosque',
		    'is_active'              => 'Active',
		    'donation_description'   => 'Donation Description'
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
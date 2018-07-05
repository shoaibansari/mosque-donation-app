<?php
namespace App\Providers;

use App\Validators\CustomValidator;
use Illuminate\Support\ServiceProvider;

class CustomValidationServiceProvider extends ServiceProvider {

	public function register() {
	}

	public function boot() {
		$this->app->validator->resolver(
			function ( $translator, $data, $rules, $messages = array(), $customAttributes = array() ) {
				return new CustomValidator( $translator, $data, $rules, $messages, $customAttributes );
			}
		);
	}

}    //end of class
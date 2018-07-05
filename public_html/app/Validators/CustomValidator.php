<?php namespace App\Validators;

use Illuminate\Validation\Validator;

class CustomValidator extends Validator {

	private $_custom_messages = array(
		"alpha_dash_spaces"     => "The :attribute may only contain letters, spaces, and dashes.",
		"alpha_num_spaces"      => "The :attribute may only contain letters, numbers, and spaces.",
		"alpha_num_dash_spaces" => "The :attribute may only contain letters, numbers, dashed and spaces.",
		"us_phone"              => "The :attribute may only contain numbers, dashes, parenthesis and spaces.",
		"raw_max"               => "The :attribute cannot exceed :raw_max characters.",
		"youtube_url"           => "Invalid :attribute.",
		"proper_url"            => "Invalid :attribute.",
	);

	public function __construct( $translator, $data, $rules, $messages = array(), $customAttributes = array() ) {
		parent::__construct( $translator, $data, $rules, $messages, $customAttributes );

		$this->_set_custom_stuff();
	}

	/**
	 * Setup any customizations etc
	 *
	 * @return void
	 */
	protected function _set_custom_stuff() {
		//setup our custom error messages
		$this->setCustomMessages( $this->_custom_messages );
	}

	/**
	 * Allow only alphabets, spaces and dashes (hyphens and underscores)
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @return bool
	 */
	protected function validateAlphaDashSpaces( $attribute, $value ) {
		return (bool)preg_match( "/^[A-Za-z\s-_]+$/", $value );
	}

	/**
	 * Allow only alphabets, numbers, and spaces
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @return bool
	 */
	protected function validateAlphaNumSpaces( $attribute, $value ) {
		return (bool)preg_match( "/^[A-Za-z0-9\s]+$/", $value );
	}

	/**
	 * Allow only alphabets, numbers, spaces and dashes (hyphens and underscores)
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @return bool
	 */
	protected function validateAlphaNumDashSpaces( $attribute, $value ) {
		return (bool)preg_match( "/^[A-Za-z0-9\s-_]+$/", $value );
	}

	/**
	 * Allow only digits, parenthesis, period & dash.
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @return bool
	 */
	protected function validateUsPhone( $attribute, $value ) {
		return (bool)preg_match( "/^[\+0-9\(\)\.-\s]+$/", $value );
	}

	protected function validateRawMax( $attribute, $value, $parameters ) {
		$length = (int)array_shift( $parameters );

		return (bool)(strlen( strip_tags( $value ) ) <= $length);
	}

	protected function replaceRawMax( $message, $attribute, $rule, $parameters ) {
		return str_replace( ':raw_max', $parameters[ 0 ], $message );
	}

	protected function validateYouTubeUrl( $attribute, $value, $parameters = [] ) {
		return preg_match( '/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/', $value );
	}

	protected function validateProperUrl( $attribute, $value, $parameters = [] ) {
		return (bool)preg_match( '/^(http:\\/\\/|https:\\/\\/)?[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $value );
	}
	
	protected function validateDate($attribute, $value, $parameters = []) {
		return strtotime( $value ) ? true : false;
	}

}
<?php



/**
 * Class PayPalExpressCheckout
 * @author Muhammad Adnan(adnan@fsdsolutions.com/adfriend2003@yahoo.com)
 * @date 2015-05-22
 */

namespace App\Classes\PayPal;

class PayPalBase {

	const CURRENCY_USD = 'USD';
	const TRANSACTION_TYPE_SALE = 'SALE';

	const BILLING_PERIOD_DAILY = 'Day';
	const BILLING_PERIOD_WEEK = 'Week';
	const BILLING_PERIOD_SEMI_MONTH = 'SemiMonth';
	const BILLING_PERIOD_MONTH = 'Month';
	const BILLING_PERIOD_YEAR = 'Year';

	const PAYMENT_METHOD_PAYPAL = 'PayPal';
	const PAYMENT_METHOD_CREDIT_CARD = 'CreditCard';
	const PAYMENT_METHOD_SCHEDULED_BILLING = 'ScheduledBilling';

	protected $debug = false, $errorMessage = "";
	protected $response = null;
	protected $paymentMethod = '', $customData = array();

	protected function __construct( $apiUserName, $apiPassword, $apiSignature, $sandbox ) {
		$this->apiUserName = $apiUserName;
		$this->apiPassword = $apiPassword;
		$this->apiSignature = $apiSignature;
		$this->sandbox = $sandbox;
	}

	public function isSandboxMod() {
		return $this->sandbox;
	}

	public function isTestMode() {
		return $this->isSandboxMod();
	}

	public function addCustomData( $key, $value ) {
		$this->customData[$key] = $value;
	}

	public function setCustomDataVal( $data ) {
		$this->customData = $data;
	}

	public function getPaymentMethod() {
		return $this->paymentMethod;
	}

	public function getTransactionId() {
		return null;
	}

	public function getProfileId() {
		return null;
	}

	public function getPayerId() {
		return null;
	}

	public function getAmount() {
		return 0.0;
	}

	public function getPaymentFee() {
		return 0.0;
	}

	public function getOrderTime() {
		return null;
	}

	public function getPayerCurrency() {
		return 'USD';
	}

	public function getPayerEmail() {
		return null;
	}

	public function getResponse() {
		return $this->response;
	}

	public function getErrorCode() {
		return $this->getResponseValue('L_ERRORCODE0');
	}

	public function getCCType() {
		return null;
	}

	public function getCCInitial() {
		return null;
	}

	public function getCCExpiryDate() {
		return null;
	}

	public function getCCBillingFirstName() {
		return null;
	}

	public function getCCBillingLastName() {
		return null;
	}

	public function getCCBillingStreet() {
		return null;
	}

	public function getCCBillingZip() {
		return null;
	}

	public function getCCBillingCity() {
		return null;
	}

	public function getCCBillingState() {
		return null;
	}

	public function getCCBillingCountry() {
		return null;
	}



	protected function getApiUserName() {
		return $this->apiUserName;
	}

	protected function getApiPassword() {
		return $this->apiUserName;
	}

	protected function getApiSignature() {
		return $this->apiUserName;
	}

	protected function getSandboxMode() {
		return $this->sandbox;
	}

	protected function getResponseValue( $key ) {
		//$this->logData( array('key' => $key, 'data' => $this->response));
		if ( !$this->response ) return null;
		if ( array_key_exists($key, $this->response) ) {
			return $this->response[$key];
		}
		return null;
	}

	protected function buildRecurringProfileDescription( $subscriptionTitle, $billingPeriod, $billingFrequency, $billingAmount, $currencyCode='USD' ) {
		$currencySymbol = '$';
		if ( $currencyCode != 'USD') {
			$currencySymbol = '';
		}
		$subscriptionTitle = trim( $subscriptionTitle );
		$subscriptionTitle .= $subscriptionTitle ? " - " : "";
		if ($billingFrequency <= 1) {
			$subscriptionTitle = sprintf( '%s %s%0.2f %s each %s', $subscriptionTitle, $currencySymbol, $billingAmount, $currencyCode, strtolower( $billingFrequency ) );
		}
		else {
			$subscriptionTitle = sprintf( '%s %s%0.2f %s every %d %ss', $subscriptionTitle, $currencySymbol, $billingAmount, $currencyCode, $billingFrequency, strtolower( $billingPeriod ) );
		}
		return trim( $subscriptionTitle );
	}

	public function getLocalTime( $timestamp=null ) {
		if ( is_null($timestamp) )
			return date( "Y-m-d H:i:s");
		return date( "Y-m-d H:i:s",  is_numeric($timestamp) ? $timestamp : strtotime($timestamp));
	}

	public function getGmtTime( $timestamp=null ) {
		if ( is_null($timestamp) )
			return gmdate( "Y-m-d\TH:i:s\Z");
		return gmdate( "Y-m-d\TH:i:s\Z", is_numeric($timestamp) ? $timestamp : strtotime($timestamp));
	}

	public function toLocalTime( $gmtTime, $format=null ) {
		$gmtTime = is_numeric($gmtTime) ? $gmtTime : strtotime($gmtTime);
		return date(is_null($format) ? spDateTime::FORMAT_DATETIME_ISO : $format, $gmtTime );
	}

	public function toGmtTime( $localTime, $format=null ) {
		$localTime = is_numeric($localTime) ? $localTime : strtotime($localTime);
		return gmdate(is_null($format) ? "Y-m-d\TH:i:s\Z" : $format, $localTime );
	}

	public function doCancelSubscription( $profileId, $notes='' ) {
		$method = 'ManageRecurringPaymentsProfileStatus';
		$nvpData = array(
			'METHOD'    => $method,
			'PROFILEID' => $profileId,
			'ACTION'    => 'Cancel',
			'NOTE'      => $notes,
		);
		return $this->doRequest( $method, $nvpData );
	}

	protected function doRequest( $nvpMethod, $nvpData ) {

		if ($this->debug) {
			$this->log( array('Method' => $nvpMethod, 'RequestData' => $nvpData) );
		}
		if (is_array( $nvpData )) {
			$tmp = array();
			foreach ($nvpData as $key => $value) {
				$value = is_array($value) ? implode('|', $value) : $value;
				$tmp[] = $key . '=' . urlencode($value);
			}
			$nvpData = implode( "&", $tmp );
		}

		// Set up your API credentials, PayPal end point, and API version.
		$apiUserName = urlencode( $this->apiUserName );
		$apiPassword = urlencode( $this->apiPassword );
		$apiSignature = urlencode( $this->apiSignature );
		$sandboxMode = $this->sandbox ? '.sandbox' : '';
		$apiEndPoint = "https://api-3t" . $sandboxMode . ".paypal.com/nvp";
		$version = urlencode( '109.0' );

		// Preparing curl request
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $apiEndPoint );
		curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		$requestData = "METHOD={$nvpMethod}&VERSION={$version}&PWD={$apiPassword}&USER={$apiUserName}&SIGNATURE={$apiSignature}&{$nvpData}";
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $requestData );

		$httpResponse = curl_exec( $ch );
		if (!$httpResponse) {
			new Exception( "$nvpMethod failed: " . curl_error( $ch ) . '(' . curl_errno( $ch ) . ')' );
		}

		parse_str( $httpResponse, $httpResponse );
		if ($this->debug) {
			$this->log ( array( 'Request' => $apiEndPoint.'?'.$requestData,'Method' => $nvpMethod, 'Response' => $httpResponse) );
		}

		// Decoding data
		if (count( $httpResponse ) > 0) {
			foreach ($httpResponse as $k => $v) {
				$httpResponse[$k] = urldecode( $v );
			}
		}

		// trying to avoid to discard previous response
		if ( $nvpMethod != 'ManageRecurringPaymentsProfileStatus' ) {
			$this->response = $httpResponse;
		}

		// Verifying Response
		if (count( $httpResponse ) == 0 || !array_key_exists( 'ACK', $httpResponse )) {
			$this->errorMessage = 'Invalid response received from server.';
			if ($this->debug) {
				if (!is_array( $nvpData )) {
					parse_str( $nvpData, $nvpData );
				}
				$this->errorMessage .= '<br><br><b>Debug Details:</b><br>Either response data is not valid OR ACK key is missing from the response.';
				$this->errorMessage .= '<br><b>Data:</b><br>';
				$this->errorMessage .= '<pre>' . print_r( array('requestData' => $nvpData, 'responseData' => $httpResponse, 'EndPoint' => $apiEndPoint), 1 ) . '</pre>';
				$this->log( '>>> Error: '.$this->errorMessage );
			}
			return false;
		}

		if (!(strtoupper( $httpResponse["ACK"] ) == "SUCCESS" || strtoupper( $httpResponse["ACK"] ) == "SUCCESSWITHWARNING")) {
			$this->errorMessage = isset($httpResponse["L_LONGMESSAGE0"]) ? $httpResponse["L_LONGMESSAGE0"] : 'No valid response received from server.';
			if ($this->debug) {
				if (!is_array( $nvpData )) {
					parse_str( $nvpData, $nvpData );
				}
				$this->errorMessage .= '<br><br><b>Debug Details:</b><br>ACK variable contains invalid state.';
				$this->errorMessage .= '<br><b>Data:</b><br>';
				$this->errorMessage .= '<pre>' . print_r( array('requestData' => $nvpData, 'responseData' => $httpResponse, 'EndPoint' => $apiEndPoint), 1 ) . '</pre>';
				$this->log( '>>> Error: '.$this->errorMessage );
			}
			return false;
		}
		return $httpResponse;
	}

	protected function log( $data ) {
		static $file = null;
		if ( !$file ) {
			$file = new FileWriter( storage_path('logs/payments.log') );
			$file->writeln( str_repeat("=", 80) );
		}
		$file->writeln( $data );
		$file->flush();
	}

	private $apiUserName, $apiPassword, $apiSignature, $sandbox = false;
}
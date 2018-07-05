<?php

/**
 * Class PayPalExpressCheckout
 * @author Muhammad Adnan(adnan@fsdsolutions.com/adfriend2003@yahoo.com)
 * @date 2015-05-22
 */
class PayPalDirectPayment extends PayPalBase {

	const METHOD_DO_DIRECT_METHOD = 'DoDirectPayment';
	const METHOD_CREATE_RECURRING_PAYMENT_PROFILE = 'CreateRecurringPaymentsProfile';
	const METHOD_GET_RECURRING_PAYMENT_PROFILE_DETAILS = 'GetRecurringPaymentsProfileDetails';

	const TASK_CREATE_SUBSCRIPTION = 'create-subscription';
	const TASK_SALE = 'sale';

	private $currencyCode, $grandTotal = 0, $totalAmount = 0, $profileStartDate;
	private $nvpData = array(), $productIndex, $task;
	private $payerEmail;
	private $ccCardType, $ccInitial, $ccExpiryDate, $ccFirstName, $ccLastName;
	private $ccStreet, $ccZip, $ccCity, $ccState, $ccCountry;

	public static function getInstance( $debug = false ) {
		static $instance = null;
		if (!$instance) {
			$settings = sp::config( 'PayPal' );
			$instance = new PayPalDirectPayment(
				$settings['apiUserName'], $settings['apiPassword'], $settings['apiSignature'], $settings['sandbox']
			);
			$instance->reset();
		}
		if ( !sp::isProduction() ) {
			$instance->debug = $debug;
		}
		return $instance;
	}

	protected function __construct( $apiUserName, $apiPassword, $apiSignature, $sandboxMode ) {
		parent::__construct( $apiUserName, $apiPassword, $apiSignature, $sandboxMode);
		$this->currencyCode = self::CURRENCY_USD;
		$this->paypalUrl = 'https://www' . ($sandboxMode ? '.sandbox' : '') . '.paypal.com';
		$this->paymentMethod = self::PAYMENT_METHOD_CREDIT_CARD;
	}

	public function setTask( $task ) {
		$this->task = $task;
	}

	public function reset() {
		$this->currencyCode = self::CURRENCY_USD;
		$this->productIndex = 0;
		$this->nvpData = array();
		$this->nvpData['LOCALECODE'] =  'EN';
		$this->grandTotal = 0;
		$this->totalAmount = 0;
	}

	public function setCreditCardInfo( $cardType, $cardNumber, $cvvNumber, $expiryYear, $expiryMonth ) {
		$this->nvpData['CREDITCARDTYPE'] = $cardType;
		$this->nvpData['ACCT'] = $cardNumber;
		$this->nvpData['EXPDATE'] = $expiryMonth.$expiryYear;
		$this->nvpData['CVV2'] = $cvvNumber;

		$this->ccCardType = $cardType;
		$this->ccInitial = substr($cardNumber, 0, 4);
		$this->ccExpiryDate = $this->getLocalTime($expiryYear.'-'.$expiryMonth.'-01');
	}

	public function setBillingDetails( $email, $firstName, $lastName, $countryCode, $state, $city, $street, $zip ) {
		$this->nvpData['EMAIL'] = $this->payerEmail = $email;
		$this->nvpData['FIRSTNAME'] = $this->ccFirstName = $firstName;
		$this->nvpData['LASTNAME'] = $this->ccLastName = $lastName;
		$this->nvpData['COUNTRYCODE'] = $this->ccCountry = $countryCode;
		$this->nvpData['STATE'] = $this->ccState = $state;
		$this->nvpData['CITY'] = $this->ccCity = $city;
		$this->nvpData['STREET'] = $this->ccStreet = $street;
		$this->nvpData['ZIP'] = $this->ccZip = $zip;
	}

	public function addProduct( $productId, $productName, $productDescription, $price, $quantity = 1 ) {
		//$this->nvpData['L_NAME0' . $this->productIndex] = $productId;
		$this->nvpData['L_NAME' . $this->productIndex] = $productName;
		$this->nvpData['L_DESC' . $this->productIndex] = $productDescription;
		$this->nvpData['L_AMT' . $this->productIndex] = $price;
		$this->nvpData['L_QTY0' . $this->productIndex] = $quantity;
		$this->nvpData['PAYMENTACTION'] = self::TRANSACTION_TYPE_SALE;
		$this->nvpData['IPADDRESS'] = $_SERVER['REMOTE_ADDR'];
		$this->nvpData['CURRENCYCODE'] = $this->currencyCode;
		$this->grandTotal += ($price * $quantity);
		$this->totalAmount += ($price * $quantity);
		$this->productIndex++;
	}

	/**
	 * @param $productId
	 * @param $subscriptionTitle
	 * @param $billingPeriod
	 * @param $billingFrequency
	 * @param $billingAmount
	 * @param bool $captureFirstPaymentImmediately
	 * @param bool $skipFirstPaymentCycle
	 * @param int $maxFailedPayments
	 * @param int $billingCycles
	 */
	public function addRecurringProfile( $subscriptionTitle, $billingPeriod, $billingFrequency, $billingAmount, $profileStartDate=null, $maxFailedPayments = 1, $billingCycles = 0  ) {

		$this->task = self::TASK_CREATE_SUBSCRIPTION;
		$subscriptionTitle = $this->buildRecurringProfileDescription( $subscriptionTitle, $billingPeriod, $billingFrequency, $billingAmount, $this->currencyCode );
		$this->profileStartDate = is_null( $profileStartDate ) ? $this->getLocalTime() : $profileStartDate;


		$this->nvpData['PROFILESTARTDATE'] = $this->toGmtTime($this->profileStartDate);
		$this->nvpData['DESC'] = $subscriptionTitle;
		$this->nvpData['BILLINGPERIOD'] = $billingPeriod;
		$this->nvpData['BILLINGFREQUENCY'] = $billingFrequency;
		$this->nvpData['AMT'] = $billingAmount;
		$this->nvpData['MAXFAILEDPAYMENTS'] = $maxFailedPayments;
		$this->nvpData['MAXFAILEDPAYMENTS'] = $maxFailedPayments;

		//$this->productIndex++;
	}

	public function setTransactionType( $type ) {
		$this->nvpData['PAYMENTACTION'] = $type;
	}

	public function setTax( $amount ) {
		$this->nvpData['TAXAMT'] = $amount;
		$this->grandTotal += $amount;
	}

	public function setShippingCost( $amount ) {
		$this->nvpData['SHIPPINGAMT'] = $amount;
		$this->grandTotal += $amount;
	}

	public function setHandlingCost( $amount ) {
		$this->nvpData['HANDLINGAMT'] = $amount;
		$this->grandTotal += $amount;
	}

	public function setShippingDiscount( $discount ) {
		$this->nvpData['SHIPDISCAMT'] = $discount;
		$this->grandTotal += $discount;
	}

	public function setInsuranceCost( $cost ) {
		$this->nvpData['INSURANCEAMT'] = urlencode( $cost );
		$this->grandTotal += $cost;
	}

//	public function setShippingAddress( $name, $street, $city, $state, $countryCode, $zip, $phoneNumber ) {
//		$this->nvpData['ADDROVERRIDE'] = 1;
//		$this->nvpData['PAYMENTREQUEST_0_SHIPTONAME'] = $name;
//		$this->nvpData['PAYMENTREQUEST_0_SHIPTOSTREET'] = $street;
//		$this->nvpData['PAYMENTREQUEST_0_SHIPTOCITY'] = $city;
//		$this->nvpData['PAYMENTREQUEST_0_SHIPTOSTATE'] = $state;
//		$this->nvpData['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE'] = $countryCode;
//		$this->nvpData['PAYMENTREQUEST_0_SHIPTOZIP'] = $zip;
//		$this->nvpData['PAYMENTREQUEST_0_SHIPTOPHONENUM'] = $phoneNumber;
//	}

	public function sendRequest() {
		$method = null;
		$prevResponse = $this->response;
		if ($this->task == self::TASK_SALE) {
			$this->setTotalAmount( $this->totalAmount );
			$this->setGrandTotal( $this->grandTotal );
			$method = self::METHOD_DO_DIRECT_METHOD;
		} else if ($this->task == self::TASK_CREATE_SUBSCRIPTION ) {
			$method = self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE;
		}
		$response = $this->doRequest( $method, $this->nvpData );
		if (!$response )
			return false;
		// merging response with prev response
		if ( is_array($prevResponse) ) {
			$this->response = array_merge($prevResponse, $this->response);
		}
		return true;
	}

	public function buildRecurringProfileDescription( $subscriptionTitle, $billingPeriod, $billingFrequency, $billingAmount, $currencyCode='USD') {
		return parent::buildRecurringProfileDescription( $subscriptionTitle, $billingPeriod, $billingFrequency, $billingAmount, $currencyCode );
	}

	public function getTransactionId() {
		return $this->getValueFromResponse('TRANSACTIONID');
	}

	public function getOrderTime() {
		return $this->getValueFromResponse('TIMESTAMP');
	}

//	public function getPaymentStatus() {
//		return $this->getValueFromResponse('PAYMENTINFO_0_PAYMENTSTATUS');
//	}
//
//	public function getPaymentPendingReason() {
//		return $this->getValueFromResponse('PAYMENTINFO_0_PENDINGREASON');
//	}

	public function getAmount() {
		return $this->getValueFromResponse('AMT');
	}

	public function getPayerCurrency() {
		return $this->getValueFromResponse('CURRENCYCODE');
	}

	public function getProfileId() {
		return $this->getValueFromResponse('PROFILEID');
	}

	public function getPayerEmail() {
		return $this->payerEmail;
	}

	public function getProfileStatus() {
		return $this->getValueFromResponse('PROFILESTATUS');
	}

	public function getSubscriptionTitle() {
		return $this->getValueFromResponse('DESC');
	}

	public function getSubscriberName() {
		return $this->getValueFromResponse('SUBSCRIBERNAME');
	}

	public function getProfileStartDate() {
		return $this->profileStartDate;
	}

	public function getCCType() {
		return $this->ccCardType;
	}

	public function getCCInitial() {
		return $this->ccInitial;
	}

	public function getCCExpiryDate() {
		return $this->ccExpiryDate;
	}

	public function getCCBillingFirstName() {
		return $this->ccFirstName;
	}

	public function getCCBillingLastName() {
		return $this->ccLastName;
	}

	public function getCCBillingStreet() {
		return $this->ccStreet;
	}

	public function getCCBillingZip() {
		return $this->ccZip;
	}

	public function getCCBillingCity() {
		return $this->ccCity;
	}

	public function getCCBillingState() {
		return $this->ccState;
	}

	public function getCCBillingCountry() {
		return $this->ccCountry;
	}

//	public function getNextBillingDate( $graceTime=null) {
//
//		$time = strtotime($this->getValueFromResponse('NEXTBILLINGDATE'));
//		if ( !is_null($graceTime) ) {
//			$time += strtotime( $graceTime );
//		}
//		return date(spDateTime::FORMAT_DATETIME_ISO, $time );
//	}

	private function getValueFromResponse( $key ) {
		if ( !$this->response ) return null;
		if ( array_key_exists($key, $this->response) ) {
			return $this->response[$key];
		}
		return null;
	}


	public function getErrorMessage() {
		return $this->errorMessage;
	}

	private function setCurrency( $currencyCode ) {
		$this->nvpData['CURRENCYCODE'] = $currencyCode;
	}

	private function setTotalAmount( $amount ) {
		$this->nvpData['ITEMAMT'] = $amount ;
	}

	private function setGrandTotal( $amount ) {
		$this->nvpData['AMT'] = $amount ;
	}

}
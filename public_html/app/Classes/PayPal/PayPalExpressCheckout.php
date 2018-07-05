<?php


/**
 * Class PayPalExpressCheckout
 * @author Muhammad Adnan(adnan@fsdsolutions.com/adfriend2003@yahoo.com)
 * @date 2015-05-22
 */


namespace App\Classes\PayPal;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PayPalExpressCheckout extends PayPalBase {

	const METHOD_SET_EXPRESS_CHECKOUT = 'SetExpressCheckout';
	const METHOD_DO_EXPRESS_CHECKOUT_PAYMENT = 'DoExpressCheckoutPayment';
	const METHOD_GET_EXPRESS_CHECKOUT_DETAILS = 'GetExpressCheckoutDetails';
	const METHOD_CREATE_RECURRING_PAYMENT_PROFILE = 'CreateRecurringPaymentsProfile';
	const METHOD_GET_RECURRING_PAYMENT_PROFILE_DETAILS = 'GetRecurringPaymentsProfileDetails';
	const METHOD_GLOBAL = 'global';

	const TASK_CREATE_SUBSCRIPTION = 'create-subscription';
	const TASK_SALE = 'sale';

	//const SESSION_KEY = 'PPS_STORED_DATA';

	private
		$paypalUrl,
		$returnUrl,
		$cancelUrl,
		$currencyCode,
		$nvpData = array(),
		$productIndex,
		$task,
		$session,
		$paymentSuccessful,
		$failedMethod = null
	;

	private
		$grandTotal = 0,
		$totalAmount = 0
	;

	public static function getInstance( $newRequest ) {
		static $instance = null;
		if (!$instance) {
			$instance = new PayPalExpressCheckout(
				config('paypal_nvp.username'),
				config('paypal_nvp.password'),
				config('paypal_nvp.signature'),
				config('paypal_nvp.sandbox'),
				config('paypal_nvp.returnUrl'),
				config('paypal_nvp.cancelUrl'),
				$newRequest
			);
			$instance->reset();
		}
		$instance->debug = config('paypal_nvp.debug');
		return $instance;
	}

	protected function __construct( $apiUserName, $apiPassword, $apiSignature, $sandboxMode, $returnUrl, $cancelUrl, $newRequest ) {
		parent::__construct( $apiUserName, $apiPassword, $apiSignature, $sandboxMode);
		$this->currencyCode = self::CURRENCY_USD;
		$this->returnUrl = $returnUrl;
		$this->cancelUrl = $cancelUrl;
		$this->paypalUrl = 'https://www' . ($sandboxMode ? '.sandbox' : '') . '.paypal.com';
		$this->paymentMethod = self::PAYMENT_METHOD_PAYPAL;
		$this->session = new SessionData();
		if ($newRequest) {
			$this->session->clear();
		}
		$this->setTransactionType( self::TRANSACTION_TYPE_SALE );
		$this->setCurrency( $this->currencyCode );
	}

	public function setTask( $task ) {
		if ( $task != self::TASK_CREATE_SUBSCRIPTION && $task != self::TASK_SALE ) {
			throw new Exception("The task should be either TASK_CREATE_SUBSCRIPTION or TASK_SALE");
		}
		$this->task = $task;
	}

	public function reset() {
		$this->currencyCode = self::CURRENCY_USD;
		$this->productIndex = 0;
		$this->nvpData = array();
		$this->nvpData['LOCALECODE'] =  'EN';
		$this->nvpData['RETURNURL'] = $this->returnUrl;
		$this->nvpData['CANCELURL'] = $this->cancelUrl;
		//$this->grandTotal = 0;
		//$this->totalAmount = 0;
	}

	public function addProduct( $productId, $productName, $productDescription, $price, $quantity = 1 ) {
		$this->nvpData['L_PAYMENTREQUEST_0_NUMBER' . $this->productIndex] = $productId;
		$this->nvpData['L_PAYMENTREQUEST_0_NAME' . $this->productIndex] = $productName;
		$this->nvpData['L_PAYMENTREQUEST_0_DESC' . $this->productIndex] = $productDescription;
		$this->nvpData['L_PAYMENTREQUEST_0_AMT' . $this->productIndex] = $price;
		$this->nvpData['L_PAYMENTREQUEST_0_QTY' . $this->productIndex] = $quantity;

		// storing in session for DoExpress state.
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_NUMBER' . $this->productIndex, $productId );
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_NAME' . $this->productIndex, $productName );
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_DESC' . $this->productIndex, $productDescription );
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_AMT' . $this->productIndex, $price );
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_QTY' . $this->productIndex, $quantity );

		$this->grandTotal += ($price * $quantity);
		$this->totalAmount += ($price * $quantity);
		$this->productIndex++;
	}

	/**
	 *
	 * TODO:: Multiple subscriptions in one go need to be fixed.
	 * @param $productId
	 * @param $subscriptionTitle
	 * @param $billingPeriod
	 * @param $billingFrequency
	 * @param $billingAmount
	 * @param $captureFirstPayment
	 * @param null $profileStartDate
	 * @param int $maxFailedPayments
	 * @param int $billingCycles
	 */
	private function addSubscription(
		$productId,
		$subscriptionTitle,
		$billingPeriod,
		$billingFrequency,
		$billingAmount,
		$captureFirstPayment,
		$profileStartDate=null,
		$maxFailedPayments = 1,
		$billingCycles = 0
	) {

		
		$subscriptionTitle = $this->buildRecurringProfileDescription( $subscriptionTitle, $billingPeriod, $billingFrequency, $billingAmount, $this->currencyCode );
		$this->nvpData['L_BILLINGAGREEMENTDESCRIPTION' . $this->productIndex] = $subscriptionTitle;
		$this->nvpData['L_BILLINGTYPE' . $this->productIndex] = 'RecurringPayments';

		if ( is_null($profileStartDate) ) {
			$profileStartDate = $this->getLocalTime();
		}

		$this->session->setMethodData( self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE, 'PROFILESTARTDATE', $this->toGmtTime($profileStartDate));
		$this->session->setMethodData( self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE, 'DESC', $subscriptionTitle );
		$this->session->setMethodData( self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE, 'BILLINGPERIOD', $billingPeriod );
		$this->session->setMethodData( self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE, 'BILLINGFREQUENCY', $billingFrequency );
		$this->session->setMethodData( self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE, 'AMT', $billingAmount );
		$this->session->setMethodData( self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE, 'MAXFAILEDPAYMENTS', $maxFailedPayments );

		if ( $captureFirstPayment ) {
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_NUMBER' . $this->productIndex, $productId );
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_NAME' . $this->productIndex, $subscriptionTitle  );
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_DESC' . $this->productIndex, $subscriptionTitle  );
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_AMT' . $this->productIndex, $billingAmount );
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'L_PAYMENTREQUEST_0_QTY' . $this->productIndex, 1  );
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_ITEMAMT',  $billingAmount );
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_AMT',  $billingAmount );
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_PAYMENTACTION', self::TRANSACTION_TYPE_SALE  );
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_CURRENCYCODE', $this->currencyCode  );
		}

		// grab initial payment before profile activation
		//$this->addSessionValue('INITAMT', $billingAmount);
		//$this->addSessionValue('FAILEDINITAMTACTION', 'FAILEDINITAMTACTION');
		$this->productIndex++;
		$this->totalAmount += $billingAmount;
		$this->grandTotal += $billingAmount;
	}

	/**
	 * @param $productId
	 * @param $title
	 * @param $billingPeriod
	 * @param $billingFrequency
	 * @param $amount
	 * @param $capturePayment
	 * @param null $startDate
	 * @param int $maxFailedPayments
	 * @param int $billingCycles
	 * @return bool
	 */
	public function doCreateSubscription(
		$productId,
		$title,
		$billingPeriod,
		$billingFrequency,
		$amount,
		$capturePayment,
		$startDate = null,
		$maxFailedPayments = 1,
		$billingCycles = 0
	) {

		$this->addSubscription( $productId, $title, $billingPeriod, $billingFrequency, $amount, $capturePayment, $startDate, $maxFailedPayments, $billingCycles );
		//$this->setTotalAmount( $this->totalAmount );PAYMENTREQUEST_0_ITEMAMT
		//$this->setGrandTotal( $this->grandTotal );
		$this->setCustomData( $this->customData );
		$this->nvpData['METHOD'] = self::METHOD_SET_EXPRESS_CHECKOUT;
		$response = $this->doRequest( self::METHOD_SET_EXPRESS_CHECKOUT, $this->nvpData );
		if (!$response) {
			$this->errorMessage = 'Unable to get token from PayPal server.';
			return false;
		}
		$this->session->setMethodData( self::METHOD_GLOBAL, 'TOKEN', $response["TOKEN"] );
		$this->session->setMethodData( self::METHOD_GLOBAL, 'IS_PAYMENT_REQUIRED', $capturePayment );
		$this->session->setMethodData( self::METHOD_GLOBAL, 'TASK', PayPalExpressCheckout::TASK_CREATE_SUBSCRIPTION );

		//_dump( Session::all(), 1 );
		$this->doRedirect();
		exit;
	}

	public function setTransactionType( $type ) {
		$this->nvpData['PAYMENTREQUEST_0_PAYMENTACTION'] = $type;
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_PAYMENTACTION', $type );
	}

	public function setTax( $amount ) {
		$this->nvpData['PAYMENTREQUEST_0_TAXAMT'] = $amount;
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_TAXAMT', $amount );
		$this->grandTotal += $amount;
	}

	public function setShippingCost( $amount ) {
		$this->nvpData['PAYMENTREQUEST_0_SHIPPINGAMT'] = $amount;
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_SHIPPINGAMT', $amount );
		$this->grandTotal += $amount;
	}

	public function setHandlingCost( $amount ) {
		$this->nvpData['PAYMENTREQUEST_0_HANDLINGAMT'] = $amount;
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_HANDLINGAMT', $amount );
		$this->grandTotal += $amount;
	}

	public function setShippingDiscount( $discount ) {
		$this->nvpData['PAYMENTREQUEST_0_SHIPDISCAMT'] = $discount;
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_SHIPDISCAMT', $discount  );
		$this->grandTotal += $discount;
	}

	public function setInsuranceCost( $cost ) {
		$this->nvpData['PAYMENTREQUEST_0_INSURANCEAMT'] = $cost;
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_INSURANCEAMT',  $cost  );
		$this->grandTotal += $cost;
	}

	public function setNoShipping() {
		$this->nvpData['NOSHIPPING'] = 1;
	}

	public function setNoInstructions() {
		$this->nvpData['ALLOWNOTE'] = 0;
	}

	public function setShippingAddress( $name, $street, $city, $state, $countryCode, $zip, $phoneNumber ) {
		$this->nvpData['ADDROVERRIDE'] = 1;
		$this->nvpData['PAYMENTREQUEST_0_SHIPTONAME'] = $name;
		$this->nvpData['PAYMENTREQUEST_0_SHIPTOSTREET'] = $street;
		$this->nvpData['PAYMENTREQUEST_0_SHIPTOCITY'] = $city;
		$this->nvpData['PAYMENTREQUEST_0_SHIPTOSTATE'] = $state;
		$this->nvpData['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE'] = $countryCode;
		$this->nvpData['PAYMENTREQUEST_0_SHIPTOZIP'] = $zip;
		$this->nvpData['PAYMENTREQUEST_0_SHIPTOPHONENUM'] = $phoneNumber;
	}

	public function setAppearance( $logoUrl, $borderColor = 'FFFFFF' ) {
		$this->nvpData['LOGOIMG'] = $logoUrl;
		$this->nvpData['CARTBORDERCOLOR'] = $borderColor;
	}

	public function doSale() {
		$this->setTotalAmount( $this->totalAmount );
		$this->setGrandTotal( $this->grandTotal );
		$this->setCustomData( $this->customData );
		$this->nvpData['METHOD'] = self::METHOD_SET_EXPRESS_CHECKOUT;
		$response = $this->doRequest( self::METHOD_SET_EXPRESS_CHECKOUT, $this->nvpData );
		if (!$response) {
			return false;
		}
		$this->session->setMethodData( self::METHOD_GLOBAL, 'TASK', self::TASK_SALE );
		$this->session->setMethodData( self::METHOD_GLOBAL, 'TOKEN', $response["TOKEN"] );
		$this->doRedirect();
		return true;
	}

	public function sendRequest() {
		if ($this->task == self::TASK_SALE) {
			$this->setTotalAmount( $this->totalAmount );
			$this->setGrandTotal( $this->grandTotal );
		}
		$this->setCustomData( $this->customData );
		$this->nvpData['METHOD'] = self::METHOD_SET_EXPRESS_CHECKOUT;
		$response = $this->doRequest( self::METHOD_SET_EXPRESS_CHECKOUT, $this->nvpData );
		if (!$response) {
			return false;
		}
		$this->session->setMethodData( self::METHOD_GLOBAL, 'TOKEN', $response["TOKEN"] );
		return $response["TOKEN"];
	}

	/**
	 * Redirecting to PayPal
	 */
	public function doRedirect() {
		Session::save();
		$url = $this->paypalUrl . '/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->session->getMethodData(self::METHOD_GLOBAL, 'TOKEN');
		(new RedirectResponse($url))->send();
	}

	public function doHandleResponse( ) {

		$subscriptionPaymentRequired = $this->session->getMethodData( self::METHOD_GLOBAL, 'IS_PAYMENT_REQUIRED');
		$this->task = $this->session->getMethodData( self::METHOD_GLOBAL, 'TASK');

		if ( $this->debug ) {
			$this->log( array('Retrieving Session Data' => $this->session->get()) );
			if ($this->task == self::TASK_SALE) {
				$this->log( '*** Task: Sale' );
			} else if ($this->task == self::TASK_CREATE_SUBSCRIPTION ) {
				$this->log( '*** Task: Subscription' );
			} else {
				$this->log( '>>> Error: No Task is selected. (Selected Task:'. $this->task .')' );
			}
		}

		//
		// Handling Sale
		//
		if ($this->task == self::TASK_SALE) {
			if (!(isset($_GET["token"]) && isset($_GET["PayerID"]))) {
				$this->errorMessage = "Token or Payer-ID not found.";
				if ( $this->debug ) {
					$this->log( '>>> Error: '.$this->errorMessage );
				}
				return false;
			}
			$data = $this->session->getMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT );
			$data['TOKEN'] = $_GET["token"];
			$data['PAYERID'] = $_GET["PayerID"];
			return $this->doRequest( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, $data );
		}


		//
		// Handling Subscription
		//
		if ($this->task == self::TASK_CREATE_SUBSCRIPTION) {

			// Applying method: GetExpressCheckoutDetails
			$data['TOKEN'] = $this->session->getMethodData( self::METHOD_GLOBAL, 'TOKEN');
			$response = $this->doRequest( self::METHOD_GET_EXPRESS_CHECKOUT_DETAILS, $data );
			if (!$response) {
				$this->failedMethod = self::METHOD_GET_EXPRESS_CHECKOUT_DETAILS;
				return false;
			}

			$returnData = $response;
			$payerId = $response['PAYERID'];
			$token = $response['TOKEN'];

			// Applying method: DoExpressCheckout if payment required
			if ( $subscriptionPaymentRequired && $data = $this->session->getMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT ) ) {
				$data['TOKEN'] = $token;
				$data['PAYERID'] = $payerId;
				if (!$response = $this->doRequest( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, $data )) {
					$this->failedMethod = self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT;
					return false;
				}
				$returnData = array_merge($returnData, $response);
				$this->paymentSuccessful = true;
			}

			// Applying method: CreateRecurringPaymentProfile
			$data = $this->session->getMethodData( self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE );
			$data['TOKEN'] = $token;
			$data['PAYERID'] = $payerId;
			if (!$response = $this->doRequest( self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE, $data) ) {
				$this->failedMethod = self::METHOD_CREATE_RECURRING_PAYMENT_PROFILE;
				return false;
			}
			$returnData = array_merge($returnData, $response);

			// Applying method: GetRecurringPaymentProfileDetails
			$data = array();
			$data['PROFILEID'] = $response['PROFILEID'];
			if ( !$response = $this->doRequest( self::METHOD_GET_RECURRING_PAYMENT_PROFILE_DETAILS, $data ) ) {
				$this->failedMethod = self::METHOD_GET_RECURRING_PAYMENT_PROFILE_DETAILS;
				return false;
			}

			$this->response = array_merge($returnData, $response);
			if ( $this->debug ) {
				$this->log( array('Complete Response' => $this->response) );
			}
			return $this->response;
		}

		return false;
	}

	public function isInitPaymentRequired() {
		return $this->session->getMethodData( self::METHOD_GLOBAL, 'IS_PAYMENT_REQUIRED' );
	}

	public function getTransactionId() {
		return $this->getResponseValue('PAYMENTINFO_0_TRANSACTIONID');
	}

	public function getOrderTime( $format="Y-m-d H:i:s") {
		return date( $format, strtotime($this->getResponseValue('TIMESTAMP') ));
	}

	public function getPaymentStatus() {
		return $this->getResponseValue('PAYMENTINFO_0_PAYMENTSTATUS');
	}

	public function getPaymentPendingReason() {
		return $this->getResponseValue('PAYMENTINFO_0_PENDINGREASON');
	}

	public function getAmount() {
		return $this->getResponseValue('PAYMENTINFO_0_AMT');
	}

	public function getPaymentFee() {
		return $this->getResponseValue('PAYMENTINFO_0_FEEAMT');
	}

	public function getPayerId() {
		return $this->getResponseValue('PAYERID');
	}

	public function getPayerEmail() {
		return $this->getResponseValue('EMAIL');
	}

	public function getPayerStatus() {
		return $this->getResponseValue('PAYERSTATUS');
	}

	public function getPayerCurrency() {
		return $this->getResponseValue('CURRENCYCODE');
	}

	public function getPayerCountry() {
		return $this->getResponseValue('COUNTRYCODE');
	}

	public function getProfileId() {
		return $this->getResponseValue('PROFILEID');
	}

	public function getProfileStatus() {
		return $this->getResponseValue('PROFILESTATUS');
	}

	public function getSubscriptionTitle() {
		return $this->getResponseValue('DESC');
	}

	public function getSubscriberName() {
		return $this->getResponseValue('SUBSCRIBERNAME');
	}

	public function getProfileStartDate( $format = "Y-m-d H:i:s") {
		return date( $format, strtotime( $this->getResponseValue('PROFILESTARTDATE') ));
	}

	public function getNextBillingDate( $graceTime=null, $format = "Y-m-d H:i:s" ) {
		$time = strtotime($this->getResponseValue('NEXTBILLINGDATE'));
		if ( !is_null($graceTime) ) {
			$time = strtotime( $graceTime, $time );
		}
		return date($format, $time );
	}

	public function getStoredData() {
		return $this->session->get();
	}

	public function removeStoredData() {
		$this->session->clear();
	}

	public function getErrorMessage() {
		return $this->errorMessage;
	}

	public function setCurrency( $currencyCode ) {
		$this->nvpData['PAYMENTREQUEST_0_CURRENCYCODE'] = $currencyCode;
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_CURRENCYCODE',  $currencyCode );
	}

	private function setTotalAmount( $amount ) {
		$this->nvpData['PAYMENTREQUEST_0_ITEMAMT'] = $amount ;
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_ITEMAMT', $amount );
	}

	private function setGrandTotal( $amount ) {
		$this->nvpData['PAYMENTREQUEST_0_AMT'] = $amount ;
		$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_AMT', $amount );
	}

	private function setCustomData( $data ) {
		if ( is_array($this->customData) && count($this->customData) > 0 ) {
			$this->nvpData['PAYMENTREQUEST_0_CUSTOM'] = json_encode($this->customData);
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_CUSTOM', json_encode($this->customData) );
		} else {
			$this->nvpData['PAYMENTREQUEST_0_CUSTOM'] = $this->customData;
			$this->session->setMethodData( self::METHOD_DO_EXPRESS_CHECKOUT_PAYMENT, 'PAYMENTREQUEST_0_CUSTOM', $this->customData );
		}
	}

//	private function storeMethodData( $method, $key, $val ) {
//		$data = Session::get(self::SESSION_KEY);
//		if (!$data) {
//			$data = array();
//		}
//		$data[$method][$key] = $val;
//		Session::put(self::SESSION_KEY, $data);
//	}
//
//	private function getMethodData( $method, $key = null) {
//		$data = Session::get( self::SESSION_KEY);
//		if ( !is_array($data) ) return null;
//		$chunk = array_key_exists( $method, $data ) ? $data[$method] : null;
//		if ( is_null($key) ) {
//			return $chunk;
//		}
//		if ( !is_array($chunk) ) return null;
//		return array_key_exists( $key, $chunk) ? $chunk[$key] : null;
//	}
//
//	private function getSessionData( $fetch = false ) {
//		$data = Session::get(self::SESSION_KEY);
//		if ($fetch) {
//			$this->clearSession();
//		}
//		return $data;
//	}
//
//	private function clearSession() {
//		Session::forgot( self::SESSION_KEY );
//	}

	public function isPaymentSuccessful() {
		return $this->paymentSuccessful;
	}

	public function getFailedMethod() {
		return $this->failedMethod;
	}
}
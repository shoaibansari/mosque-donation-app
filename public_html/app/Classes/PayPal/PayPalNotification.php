<?php
namespace App\Classes\PayPal;

class PayPalNotification extends PayPalBase {

	private $logger, $data, $paypalUrl;

	public static function getInstance( $debug = false ) {
		static $instance = null;
		if (!$instance) {
			$settings = sp::config( 'PayPal' );
			$instance = new PayPalNotification( $settings['sandbox'] );
		}
		$instance->debug = $debug;
		return $instance;
	}

	protected function __construct( $sandbox=false ) {
		parent::__construct('', '', '', $sandbox);
		$this->paypalUrl = "https://www".($sandbox ? '.sandbox' : '').".paypal.com/cgi-bin/webscr";
		$this->logger = new FileWriter( storage_path('logs/paypal-ipn.log') );
	}

	public function getType() {
		return $this->getDataFromPost('txn_type');
	}

	public function isRecurringProfileCreated() {
		return strcmp($this->getType(), 'recurring_payment_profile_created') == 0;
	}

	public function isRecurringPayment() {
		return strcmp($this->getType(), 'recurring_payment') == 0;
	}

	public function getNextPaymentDate() {
		return spDateTime::toSqlDateTime( $this->getDataFromPost('next_payment_date') );

	}

	public function isRecurringPaymentFailed() {
		return strcmp($this->getType(), 'recurring_payment_failed') == 0;
	}

	public function isRecurringPaymentSkipped() {
		return strcmp($this->getType(), 'recurring_payment_skipped') == 0;
	}

	public function isRecurringProfileSuspended() {
		return strcmp($this->getType(), 'recurring_payment_suspended_due_to_max_failed_payment') == 0;
	}

	public function isRecurringProfileCanceled() {
		return strcmp($this->getType(), 'recurring_payment_profile_cancel') == 0;
	}

	public function getRecurringAmount() {
		return $this->getDataFromPost('amount_per_cycle');
	}

	public function getTransactionId() {
		return $this->getDataFromPost('txn_id');
	}

	public function getProfileId() {
		return $this->getDataFromPost('recurring_payment_id');
	}

	public function getPaymentType() {
		return $this->getDataFromPost('payment_type');
	}

	public function getPaymentFee() {
		return $this->getDataFromPost('payment_fee');
	}

	public function isTestNotification() {
		return $this->getDataFromPost('test_ipn');
	}

	public function getTime() {
		if ( $time = $this->getDataFromPost('time_created') ) {
			return $this->toLocalTime($time);
		}
		return null;
	}

	public function getFirstName() {
		return $this->getDataFromPost('first_name');
	}

	public function getLastName() {
		return $this->getDataFromPost('last_name');
	}

	public function getPayerEmail() {
		return $this->getDataFromPost('payer_email');
	}

	public function getShippingAmount() {
		return $this->getDataFromPost('shipping');
	}

	private function getDataFromPost( $key ) {
		if ( isset($this->data[$key]) ) {
			//return $this->toLocalTime($this->data[$key]);
			return $this->data[$key];
		}
		return null;
	}


	public function isValid() {

		$debug = true;

		$this->logger->writeln( spDateTime::getDateTime() . "****************[ IPN Processing ]****************" );

		// Read POST data
		// reading posted data directly from $_POST causes serialization
		// issues with array data in POST. Reading raw POST data from input stream instead.
		$raw_post = file_get_contents( 'php://input' );
		if ( $debug ) {
			$this->logger->writeln("Raw Post Received: ".$raw_post);
		}
		/*
		$raw_post_array = explode( '&', $raw_post_data );
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode( '=', $keyval );
			if (count( $keyval ) == 2) {
				$myPost[ $keyval[0] ] = urldecode( $keyval[1] );
			}
		}
		*/
		parse_str( $raw_post, $receivedData );
		if ( is_array($receivedData) ) {
			foreach($receivedData as $i => $v ) {
				$receivedData[$i] = urldecode($v);
			}
		}

		// read the post from PayPal system and add 'cmd'
		$post_back_request = 'cmd=_notify-validate';
		$magic_quotes_status = function_exists( 'get_magic_quotes_gpc' ) && (get_magic_quotes_gpc() == 1);
		foreach ( $receivedData as $key => $value) {
			$post_back_request .= "&$key=".( $magic_quotes_status ? urlencode(stripslashes($value)) : urlencode($value) );
		}

		// Post IPN data back to PayPal to validate the IPN data is genuine
		// Without this step anyone can fake IPN data
		if ( $debug ) {
			$this->logger->writeln(
				array('Task' => 'POST BACK REQUEST', 'URL' => $this->paypalUrl, 'Request' => $post_back_request
				)
			);
		}
		$ch = curl_init( $this->paypalUrl );
		if ($ch == false) {
			return false;
		}

		curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_back_request );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
		curl_setopt( $ch, CURLOPT_FORBID_REUSE, 1 );
		if ( $this->debug == true) {
			curl_setopt( $ch, CURLOPT_HEADER, 1 );
			curl_setopt( $ch, CURLINFO_HEADER_OUT, 1 );
		}

		// CONFIG: Optional proxy configuration
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

		// Set TCP timeout to 30 seconds
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Connection: Close') );

		// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
		// of the certificate as shown below. Ensure the file is readable by the webserver.
		// This is mandatory for some environments.
		//$cert = __DIR__ . "/cacert.pem";
		//curl_setopt( $ch, CURLOPT_CAINFO, $cert );

		$res = curl_exec( $ch );
		if (curl_errno( $ch ) != 0) {
			$this->logger->writeln( "Can't connect to PayPal to validate IPN message: " . curl_error( $ch ), true );
			curl_close( $ch );
			return false;
		}
		curl_close( $ch );

		// Inspect IPN validation result and act accordingly
		// Split response headers and payload, a better way for strcmp
		$tokens = explode( "\r\n\r\n", trim( $res ) );
		$res = trim( end( $tokens ) );
		if (strcmp( $res, "VERIFIED" ) == 0) {
			$this->logger->writeln( "*** IPN Verified *** " );
			$this->logger->writeln( $receivedData );
			// check whether the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment and mark item as paid.
			$this->data = $receivedData;
			return true;
		}

		if (strcmp( $res, "INVALID" ) == 0) {
			// log for manual investigation
			// Add business logic here which deals with invalid IPN messages
			$this->logger->writeln( "*** Invalid IPN *** " );
		}

		return false;
	}

	public function getData() {
		return $this->data;
	}

	/**
	 * setData call is only for testing purpose
	 * @param $data
	 */
	public function setData( $data ) {
		if ( !is_array($data) ) {
			parse_str( $data, $receivedData );
			if ( is_array($receivedData) ) {
				foreach($receivedData as $i => $v ) {
					$receivedData[$i] = urldecode($v);
				}
			}
			$this->data = $receivedData;
		} else if ( is_array($data) ){
			$this->data = $data;
		} else {
			sp::log("Required data should be in array format.");
		}
	}
}
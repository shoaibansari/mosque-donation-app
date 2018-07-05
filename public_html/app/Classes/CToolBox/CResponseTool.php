<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/26/2016
 * Time: 6:19 AM
 */

namespace App\Classes\CToolBox;

class CResponseTool {
	
	private $response, $flashMessage;
	
	/**
	 * CResponseTool constructor.
	 */
	public function __construct() {
		$this->response = [];
		$this->response['type'] = 'unknown';
		$this->response['httpCode'] = '0';
		$this->response['message'] = '';
		$this->response['data'] = null;
		$this->response['headers'] = [];
	}
	
	/**
	 * @return CResponseTool
	 */
	public static function instance() {
		static $instance;
		if(!$instance) {
			$instance = new CResponseTool();
		}
		
		return $instance;
	}
	
	/**
	 *
	 * @param $message
	 * @param null $data
	 * @param int $status
	 * @param array $headers
	 * @return $this
	 */
	public function success($message, $data = null, $status = 200, $headers = []) {
		$this->response['httpCode'] = $status;
		$this->response['message'] = $message;
		$this->response['data'] = $data;
		$this->response['headers'] = $headers;
		
		return $this;
	}
	
	/**
	 *
	 * @param $message
	 * @param null $data
	 * @param int $code
	 * @param array $headers
	 * @return $this
	 */
	public function error($message, $data = null, $code = 422, $headers = []) {
		$this->response = [];
		$this->response['httpCode'] = $code;
		$this->response['message'] = $message;
		$this->response['data'] = $data;
		$this->response['headers'] = $headers;
		
		return $this;
	}
	
	public function withFlash($keys = null, $message = null) {
		$this->flashMessage = null;
		if(is_array($keys)) {
			$this->flashMessage = $message;
		}
		else if(is_null($keys)) {
			$this->flashMessage = true;
		}
		else {
			$this->flashMessage[ $keys ] = $message;
		}
		
		return $this;
	}
	
	/**
	 * @param $data
	 * @param int $status
	 * @param array $headers
	 * @return $this
	 */
	public function data($data, $status = 200, $headers = []) {
		$this->response['httpCode'] = $status;
		$this->response['message'] = null;
		$this->response['data'] = $data;
		$this->response['headers'] = $headers;
		
		return $this;
	}
	
	/**
	 * @param null $data
	 * @param int $code
	 * @return $this
	 */
	public function formErrors($data = null, $code = 422) {
		$this->response = [];
		$this->response['httpCode'] = $code;
		$this->response['data'] = $data;
		$this->response['ajaxFormErrors'] = true;
		
		return $this;
	}
	
	/**
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function send() {
		
		if(array_key_exists('ajaxFormErrors', $this->response)) {
			return response(json_encode($this->response['data']), $this->response['httpCode'], $this->response['headers']);
		}
		
		$json = [];
		if ( is_null($this->response['message']) ) {
			$json = $this->response['data'];
		}
		else {
			$json['message'] = $this->response['message'];
			if(!is_null($this->response['data']) && $this->response['data']) {
				$json['data'] = $this->response['data'];
			}
		}
		
		if($this->flashMessage) {
			$error = $this->response['httpCode'] != 200;
			if($this->flashMessage === true) {
				session()->flash($error ? 'alert-danger' : 'alert-success', $json['message']);
			}
			else if(is_array($this->flashMessage)) {
				foreach($this->flashMessage as $key => $message) {
					session()->flash($key, $message);
				}
			}
		}
		
		if ( !$this->response['headers'] || request()->expectsJson() ) {
			$this->response['headers'] = ['Content-Type' => 'application/json'];
		}
		
		return response(json_encode($json), $this->response['httpCode'], $this->response['headers']);
	}
	
	/**
	 *
	 * @param $url
	 * @param int $status
	 * @param array $headers
	 * @param null $secure
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function redirect($url, $status = 302, $headers = [], $secure = null) {
		$error = $this->response['httpCode'] != 200;
		$message = $this->response['message'];
		if($this->flashMessage) {
			if($this->flashMessage === true) {
				session()->flash($error ? 'alert-danger' : 'alert-success', $message);
			}
			else if(is_array($this->flashMessage)) {
				foreach($this->flashMessage as $key => $message) {
					session()->flash($key, $message);
				}
			}
		}
		else if($message) {
			session()->flash($error ? 'alert-danger' : 'alert-success', $message);
		}
		
		return redirect($url, $status, $headers, $secure);
	}
	
}
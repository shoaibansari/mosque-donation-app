<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $validationErrors;
    
    const NO_ERROR = 200;
    const ERROR_VALIDATION = 422;
    const ERROR_CRITICAL = 500;
	const ERROR_NOT_IMPLEMENTED = 501;
    
    protected function sendResponse($message, $data=[] ) {
	    return toolbox()
		    ->response()
		    ->success($message, $data, self::NO_ERROR)
		    ->send();
    }
    
    protected function sendNotImplementedErrorResponse( $message=null ) {
	    return toolbox()
		    ->response()
		    ->error((is_null($message) ? 'Not Implemented': $message), null, self::ERROR_NOT_IMPLEMENTED)
		    ->send();
    }
    
    protected function sendErrorResponse($message, $data=null, $httpErrorCode=null ) {
    	return toolbox()
		    ->response()
		    ->error( $message, $data, is_null($httpErrorCode) ? self::ERROR_VALIDATION : $httpErrorCode)
		    ->send();
    }
    
    protected function sendCriticalErrorResponse($message, $data=null ) {
	    return toolbox()
		    ->response()
		    ->error($message, $data, self::ERROR_CRITICAL)
		    ->send();
    }
	
	protected function sendData($data, $httpStatusCode=self::NO_ERROR) {
		return toolbox()
			->response()
			->data($data, $httpStatusCode)
			->send();
	}
	
	protected function validate( $request, $rules, $messages=[]) {
		$validator = Validator::make( $request->all(), $rules,$messages);
		if( $validator->fails() ) {
			$this->validationErrors = $validator->messages();
			return false;
		}
		return true;
	}
	
	protected function getValidationMessages() {
		return $this->validationErrors;
	}
    

}

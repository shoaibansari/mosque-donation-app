<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class PrayerTimeController extends ApiController {
    
    public function getPrayerTime(Request $request)
    {

    	if(!$this->validate(
            $request, [
            'latitude'         => 'required',
            'longitude'        => 'required',
            'timestamp'		   => 'required'
            
        ])) {
            return $this->sendErrorResponse('Please correct errors', $this->getValidationMessages());
        }
	    $client = new \GuzzleHttp\Client();
	   

		$response = $client->get('http://api.aladhan.com/v1/timings/'.$request->timestamp.'?latitude='.$request->latitude.'&longitude='.$request->longitude, [
		    'headers' => [
		        'token' => $request->token,
		    ],
		  
		]);

		// You need to parse the response body
		// This will parse it into an array
		$response = json_decode($response->getBody(), true);

	    return $this->sendResponse('Successfully Fetch.', $response['data']['timings']);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Repositories\Eloquent\UserDeviceRepository;
use Closure;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$token = $request->input('token');
    	
    	if ( !$token ) {
		    return response()->json(['message' => 'Token is required'], 422);
	    }
	    else if ( !UserDeviceRepository::instance()->findUserByToken($request->input('token') ) ) {
		    return response()->json(['message' => 'Invalid or expired token'], 422);
	    }
	    
	    return $next($request);
    }
}

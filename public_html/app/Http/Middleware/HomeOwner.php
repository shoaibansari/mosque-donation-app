<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HomeOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
		$auth = Auth::guard( $guard );
        if ( !$auth->check() || !$auth->user()->isHomeOwner() ) {
        	return redirect()->back()->with('error', 'Access denied');
        }

	    return $next( $request );


    }
}

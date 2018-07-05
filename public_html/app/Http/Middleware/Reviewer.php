<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class Reviewer
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
        if ( !$auth->check() || !$auth->user()->hasRole( Role::TYPE_REVIEWER ) ) {
        	return redirect()->back()->with('error', 'Access denied');
        }

	    return $next( $request );
    }

    
}

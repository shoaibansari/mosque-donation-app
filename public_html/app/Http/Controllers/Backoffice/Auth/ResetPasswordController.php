<?php

namespace App\Http\Controllers\Backoffice\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
    	$this->redirectTo = route('admin.login' );
        $this->middleware('guest');
    }

    public function showResetForm( Request $request, $token = null ) {
		return view( toolbox()->backend()->view('auth.passwords.reset'), compact('token') );
    }

    public function broker() {
        return Password::broker('admins');
    }

    public function guard() {
	    return auth( 'admin' );
    }

}

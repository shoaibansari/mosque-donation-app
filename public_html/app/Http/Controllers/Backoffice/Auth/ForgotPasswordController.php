<?php

namespace App\Http\Controllers\Backoffice\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct() {
        $this->middleware('guest');
    }


    public function showLinkRequestForm() {
	    return view( toolbox()->backend()->view( 'reset-password' ) );
    }

	public function sendResetLinkResponse( $response ) {
		return redirect()->route( 'admin.login' )->with( 'status', trans( $response ) );
	}

    public function broker() {
        return Password::broker('admins');
    }


}

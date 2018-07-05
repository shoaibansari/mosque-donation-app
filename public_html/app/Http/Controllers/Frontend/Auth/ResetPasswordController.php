<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct( )
    {
        $this->middleware('guest');
    }


    /**
	 * Display the password reset view for the given token.
	 *
	 * If no token is present, display the link request form.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  string|null $token
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showResetForm( Request $request, $token = null ) {

		$token = $request->token;
		$reminder = Reminder::where( 'email', $request->email )->first();
		//dd( $token, Hash::check( $token, $reminder->token ) );

		// Password request will consider expired after certain time.
		$elapsedTime = Carbon::now()->subHours( env('EXPIRE_FORGOT_PASSWORD_REQUEST', 24) );

		if ( !$reminder || !Hash::check( $request->token, $reminder->token ) || $elapsedTime->gte($reminder->created_at)  ) {
			return redirect( route( 'home' ) )->with( 'error', 'Invalid or expired password request token.' );
		}

		return view( 'auth.passwords.reset' )->with(
			['token' => $token, 'email' => $request->email]
		);
	}


	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
//	public function reset( Request $request ) {
//		$this->validate( $request, $this->rules(), $this->validationErrorMessages() );
//
//		// Here we will attempt to reset the user's password. If it is successful we
//		// will update the password on an actual user model and persist it to the
//		// database. Otherwise we will parse the error and return the response.
//		$response = $this->broker()->reset(
//			$this->credentials( $request ), function ( $user, $password ) {
//			$this->resetPassword( $user, $password );
//		});
//
//
//		// If the password was successfully reset, we will redirect the user back to
//		// the application's home authenticated view. If there is an error we can
//		// redirect them back to where they came from with their error message.
//		return $response == Password::PASSWORD_RESET
//			? $this->sendResetResponse( $response )
//			: $this->sendResetFailedResponse( $request, $response );
//	}

}

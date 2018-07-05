<?php
namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\LoginRequest;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    
	use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        return redirect( route('home') )->with('showLoginForm', true);
    }

	public function login( LoginRequest $request ) {

	    $this->validateLogin( $request );

	    // If the class is using the ThrottlesLogins trait, we can automatically throttle
	    // the login attempts for this application. We'll key this by the username and
	    // the IP address of the client making these requests into this application.
	    if ( $this->hasTooManyLoginAttempts( $request ) ) {
		    $this->fireLockoutEvent( $request );

		    return $this->sendLockoutResponse( $request );
	    }

	    if ( $this->attemptLogin( $request ) ) {

	    	$user = auth()->user();

	    	$err = null;
	    	if ( $user->is_blocked ) {
	    		$err = 'Your account has been disabled. Please contact admin.';
		    }
		    else if ( !$user->is_confirmed ) {
			    $err = 'Your email account is not yet verified. Please check your email and follow the instructions to verify your account.';
		    }
		    else if ( $user->isAdmin() ) {
	    		// Admin user is not allowed to login from the frontend
	    		$err = trans( 'auth.failed' );
		    }


		    if ( $err ) {
	    	    auth()->logout();

			    if ( $request->expectsJson() ) {
				    return response()->json( [ 'message' => $err ], 422 );
			    }

	    	    return redirect( route('home') )->with('error', $err );
		    }

		    // Updating last login time.
		    $user->last_login_at = Carbon::now();
	    	$user->save();

		    return $this->sendLoginResponse( $request );
	    }

	    // If the login attempt was unsuccessful we will increment the number of attempts
	    // to login and redirect the user back to the login form. Of course, when this
	    // user surpasses their maximum number of attempts they will get locked out.
	    $this->incrementLoginAttempts( $request );

	    return $this->sendFailedLoginResponse( $request );

    }

	/**
	 * Send the response after the user was authenticated.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	protected function sendLoginResponse( Request $request ) {
		$request->session()->regenerate();

		$this->clearLoginAttempts( $request );

		if ( $request->expectsJson() ) {
			return response()->json( ['redirect' => url($this->redirectTo) ] );
		}

		return $this->authenticated( $request, $this->guard()->user() )
			?: redirect()->intended( $this->redirectPath() );
	}

	/**
	 * Get the failed login response instance.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendFailedLoginResponse( Request $request ) {

		if ( $request->expectsJson() ) {
			return response()->json( ['message' => trans( 'auth.failed' ) ], 422 );
		}

		return redirect('/')
			->withInput( $request->only( $this->username(), 'remember' ) )
			->with( 'showLoginForm', true )
			->with( 'error', trans( 'auth.failed' ) );     // it should be "errors" and not "error", coz to show errors inside the login dialog.
	}

	protected function credentials( Request $request ) {
		return $request->only( $this->username(), 'password' );
	}
}

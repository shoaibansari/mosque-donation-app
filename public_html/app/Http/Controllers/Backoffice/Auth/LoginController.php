<?php
namespace App\Http\Controllers\Backoffice\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '';


    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->redirectTo = route( 'admin.dashboard');
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request) {

    	// if admin session exist then redirect user to admin.
	    if ( auth( 'admin' )->check() ) {
		    return redirect( route('admin.dashboard') );
	    }

        if ( auth()->check() ){
            return redirect()->route('admin.dashboard');
        }

		return view( toolbox()->backend()->view('login') );
    }

	public function login( Request $request ) {


    	// Validate the form data
		$this->validate(
			$request, [
			'email'    => 'required|email',
			'password' => 'required|min:6'
		]);

		//dd( $request->email, $request->password, Role::TYPE_ADMIN, bcrypt('abcd#1234') );
		// Attempt to log the user in
		if ( Auth::guard( 'admin' )->attempt( [
			'email' => $request->email,
			'password' => $request->password,
			'id' => User::ADMIN_ID ], $request->rememberme ? true : false )
		) {
			// if successful, then redirect to their intended location
			return redirect()->intended( route( 'admin.dashboard' ) );
		}

		// if unsuccessful, then redirect back to the login with the form data
		return redirect()->back()->withInput( $request->only( 'email', 'remember' ) )->with('error', 'Invalid username or password.');
	}


    public function logout( Request $request ) {
	    auth('admin')->logout();
	    session()->invalidate();
	    return redirect( route('admin.login') )->with('success', 'Logout successfully.');
    }

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return array
	 */
	protected function credentials( Request $request ) {
		return $request->only( $this->username(), 'password' ) + [ 'id' => User::ADMIN_ID ];
	}


}

<?php
namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Requests\Frontend\SignupRequest;
use App\Models\Repositories\Eloquent\UserRepository;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\UserLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';


    protected $userRepository;


	/**
	 * RegisterController constructor.
	 * @param UserRepository $userRepository
	 */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
    }


	/**
	 * Homeowner Signup
	 *
	 * @param SignupRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function register( SignupRequest $request ) {

    	$user = $this->userRepository;
    	$data = $request->except(['_token']);
	    if ( !$user->register($data) ) {
		    return redirect()->back()->with( 'error', $user->getErrorMessage() );
	    }

	    return redirect()->back()
		    ->with('success', $user->getData('success') )
		    ->with('details', $user->getData('details') );
    }


    public function confirmation( $code ) {

    	if ( !$this->userRepository->confirmByCode( $code ) ) {
		    return redirect( route( 'home' ) )->with( 'error', $this->userRepository->getErrorMessage() );
	    }

	    return redirect( route( 'home' ) )
		    ->with( 'success', 'Congratulation! Your email account has been verified.' );

    }

}

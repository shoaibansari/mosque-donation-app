<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Repositories\Eloquent\NewsletterSubscriberRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{
	private $newsletter;

    public function __construct( NewsletterSubscriberRepository $newsletterSubscriberRepository ) {
        $this->newsletter = $newsletterSubscriberRepository;
    }

    public function postSignup( Request $request ) {

    	$this->validate( $request, [
    		'email' => 'required|email|max:255'
	    ]);

		$email = trim( $request->email );
		$subscription = $this->newsletter->getModel()->whereEmail( $email )->first();
		if ( !$subscription ) {
			if ( !$this->newsletter->create( [
				'email' => $email,
				'active' => 1,
				'optout' => 0,
				'category_id' => Category::TYPE_GENERAL
			]) ) {
				return toolbox()->response()->formErrors( ['email' => ['Unable to subscribe. Please try again later.']] )->send();
			}
		}
		else {

			// email not allowed
			if ( !$subscription->active ) {
				return toolbox()->response()->formErrors( ['email' => ['Your email address is blocked. Please contact admin.'] ])->send();
			}


			if ( !$subscription->optout ) {
				return toolbox()->response()->formErrors( ['email' => ['Your are already subscribed.']] )->send();
			}

			// user might opt-out previously, so activating it.
			$subscription->optout = 0;
			$subscription->save();
		}

	    return toolbox()->response()->success( 'You have successfully subscribed for the newsletter.' )->send();
    }

}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\ContactUsRequest;
use App\Models\EmailTemplate;
use App\Models\Repositories\Eloquent\ContactUsRepository;
use App\Models\Repositories\Eloquent\CountryRepository;
use App\Models\Repositories\Eloquent\DiscriminationRepository;
use App\Models\Repositories\Eloquent\EmailTemplateRepository;
use App\Models\Repositories\Eloquent\PageRepository;
use App\Models\Repositories\Eloquent\VideoRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PageController extends Controller {

	protected
		$pageRepo,
		$contactUsRepo
	;

	public function __construct(
		PageRepository $pageRepo,
		ContactUsRepository $contactUsRepo
	) {
		$this->pageRepo = $pageRepo;
		$this->contactUsRepo = $contactUsRepo;
	}

	/**
	 * Home Page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function homePage() {

		if( auth()->check() ) {
			return redirect( route('dashboard') );
		}

        //return redirect( route('home') );
        $page = $this->pageRepo->getBySlug( '' );

        return view( toolbox()->frontend()->view( 'pages.home'), compact( 'page' ) );
	}

	/**
	 * Inner pages of frontend
	 *
	 * @param $slug
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getPageBySlug( $slug ) {

		if ( !$page = $this->pageRepo->getBySlug( $slug ) ) {
			abort( 404 );
		}

		// default view
		$view = 'pages.inner';

		// default banner - child views can override the default one.
		$banner = $page->hasBanner() ? $page->bannerImageUrl() : null;
		if ( $page->isContactUs() ) {
			$view = 'pages.contact-us';
		}

		return view( toolbox()->frontend()->view( $view ), compact( 'page', 'banner') );

	}

	public function postContactUs( ContactUsRequest $request ) {

		$data = collect( Input::all() )->except( '_token', 'g-recaptcha-response' )->toArray();
		$data[ 'ip' ] = toolbox()->ip()->get();
		$data[ 'country' ] = toolbox()->ip()->countryCode();

		if ( !$this->contactUsRepo->create( $data ) ) {
			$error = 'Unable to dispatch request.';
			if ( $request->ajax() ) {
				return toolbox()->response()->error( $error )->send();
			}

			return redirect()->back()->with( 'error', $error )->withInput();
		}

		// Sending email
		if ( !$this->emailTemplate->sendUsingTemplate(
			$request->email, EmailTemplate::CONTACT_US, [
			'NAME'         => $request->name,
			'EMAIL'        => $request->email,
			'PHONE'        => $request->phone,
			'WEBSITE'      => $request->website ? $request->website : 'N/A',
			'MESSAGE'      => $request->message,
			'WEBSITE_NAME' => settings()->getAppName(),
			'IP_ADDRESS'   => toolbox()->ip()->get(),
			'COUNTRY'      => toolbox()->ip()->countryName()
		])
		) {
			$error = 'Unable to send email.';
			if ( $request->ajax() ) {
				return toolbox()->response()->error( $error )->send();
			}

			return redirect()->back()->with( 'error', $error );
		}

		$message = 'Our team will review your request and will contact you shortly.';
		if ( $request->ajax() ) {
			return toolbox()->response()->success( $message )->send();
		}

		return redirect( route( 'contactUsPage' ) )->with( 'success', $message );
	}

}

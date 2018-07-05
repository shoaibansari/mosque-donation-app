<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Requests\Backoffice\PageUpdateRequest;
use App\Models\Page;
use App\Models\Repositories\Eloquent\PageRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Facades\Datatables;
use Intervention\Image\Facades\Image;
use App\DataTables\Backoffice\PagesDataTable;

class PageController extends Controller {

	protected $pageRepository;

	public function __construct( PageRepository $pageRepository ) {
		$this->pageRepository = $pageRepository;
	}

	public function index(PagesDataTable $dataTable) {
		toolbox()->pluginsManager()->plugins(['datatables']);
		return $dataTable->render( toolbox()->backend()->view( 'pages.manage' ) );
	}

	public function postManageData() {
		return Datatables::of( Page::query() )->make( true );
	}

	public function edit( $id ) {
		if ( !$page = $this->pageRepository->findById( $id ) ) {
			return redirect( route( 'admin.pages.manage' ) )->with( 'error', 'Unable to find requested page.' );
		}

		$action = 'edit';
		return view( toolbox()->backend()->view( 'pages.edit' ), compact( 'page', 'action' ) );
	}

	public function update( PageUpdateRequest $request ) {

		// retrieving page
		if ( !$page = $this->pageRepository->findById( $request->id ) ) {
			return redirect( route( 'admin.pages.manage' ) )->with( 'error', 'Unable to find requested page.' );
		}

		// updating page
		$page->update( $request->except( ['_token', 'banner'] ) );

		// moving thumbnail
		if ( $request->banner ) {
//			$thumbnailFile = $request->banner->move( $this->thumbStoragePath, $video->id . '-O.png' );
//
//			// resizing thumbnails
//			Image::make( $thumbnailFile )->fit( 956, 362 )
//				->save( $this->thumbStoragePath . '/' . $video->id . '-L.png' );
//			Image::make( $thumbnailFile )->fit( 477, 368 )
//				->save( $this->thumbStoragePath . '/' . $video->id . '-M.png' );
//			Image::make( $thumbnailFile )->fit( 215, 198 )
//				->save( $this->thumbStoragePath . '/' . $video->id . '-S.png' );
		}

		return redirect( route( 'admin.pages.manage' ) )->with( 'success', 'Page has been updated.' );
	}

	public function delete( $id ) {
		if ( !$video = $this->videoRepository->getModel()->find( $id ) ) {
			return redirect( route( 'admin.videos.manage' ) )->with( 'error', 'Unable to find requested video.' );
		}

		$video->delete();

		return redirect( route( 'admin.videos.manage' ) )->with( 'success', 'Video has been deleted "' . $video->title . '".' );
	}

	public function postPublishStatus( Request $request ) {
		if ( !$page = $this->pageRepository->findById( $request->id ) ) {
			abort(404, 'Page not found');
		}
		$page->published = $request->status ? 1 : 0;
		$page->save();
		return toolbox()->response()->success('Page status has been updated.')->send();
	}

	/**
	 * Home Page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
//	public function home() {
//		$page = $this->pageRepository->getBySlug( '' );
//		return view(
//			toolbox()->frontend()->view( 'pages.home' ),
//			compact( 'page')
//		);
//	}

//	public function getPageBySlug( $slug ) {
//
//		if ( !$page = $this->pageRepository->getBySlug( $slug ) ) {
//			abort( 404 );
//		}
//
//		// default view
//		$view = 'pages.default';
//
//		// default banner - child views can override the default one.
//		$banner = $page->hasBanner() ? $page->bannerImageUrl() : null;
//		if ( $page->isContactUs() ) {
//			$view = 'pages.contact-us';
//		}
//
//		return view( toolbox()->frontend()->view( $view ), compact( 'page') );
//
//	}

//	public function postContactUs( ContactUsRequest $request ) {
//
//		$data = collect( Input::all() )->except( '_token', 'g-recaptcha-response' )->toArray();
//		$data[ 'ip' ] = toolbox()->ip()->get();
//		$data[ 'country' ] = toolbox()->ip()->countryCode();
//
//		if ( !$this->contactUs->create( $data ) ) {
//			$error = 'Unable to dispatch request.';
//			if ( $request->ajax() ) {
//				return toolbox()->response()->error( $error )->send();
//			}
//
//			return redirect()->back()->with( 'error', $error )->withInput();
//		}
//
//		// Sending email
//		if ( !$this->emailTemplate->sendUsingTemplate(
//			$request->email, EmailTemplate::CONTACT_US, [
//			'NAME'         => $request->name,
//			'EMAIL'        => $request->email,
//			'PHONE'        => $request->phone,
//			'WEBSITE'      => $request->website ? $request->website : 'N/A',
//			'MESSAGE'      => $request->message,
//			'WEBSITE_NAME' => settings()->getAppName(),
//			'IP_ADDRESS'   => toolbox()->ip()->get(),
//			'COUNTRY'      => toolbox()->ip()->countryName()
//		])
//		) {
//			$error = 'Unable to send email.';
//			if ( $request->ajax() ) {
//				return toolbox()->response()->error( $error )->send();
//			}
//
//			return redirect()->back()->with( 'error', $error );
//		}
//
//		$message = 'Our team will review your request and will contact you shortly.';
//		if ( $request->ajax() ) {
//			return toolbox()->response()->success( $message )->send();
//		}
//
//		return redirect( route( 'contactUsPage' ) )->with( 'success', $message );
//	}

}

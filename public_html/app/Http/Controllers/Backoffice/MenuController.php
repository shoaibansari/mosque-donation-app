<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Requests\Backoffice\MenuItemCreateRequest;
use App\Http\Requests\Backoffice\MenuItemUpdateRequest;
use App\Models\MenuItem;
use App\Models\Repositories\Eloquent\MenuRepository;
use App\Models\Repositories\Eloquent\PageRepository;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
	private $menuRepository, $pageRepository;

	public function __construct( MenuRepository $menuRepository, PageRepository $pageRepository) {
		$this->menuRepository = $menuRepository;
		$this->pageRepository = $pageRepository;
	}

	public function index() {
		$menus = MenuRepository::instance()->getMenus( null );
		return view( toolbox()->backend()->view('menus.manage'), compact('menus'));
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function postActiveStatus( Request $request ) {
		if ( !$menuItem = $this->menuRepository->getMenuItemById( $request->id ) ) {
			abort( 404, 'Menu item not found' );
		}
		$menuItem->active = $request->status ? 1 : 0;
		$menuItem->save();

		return toolbox()->response()->success( 'Menu status has been changed.' )->send();
	}

	/**
	 * @param Request $request
	 */
	public function postSortItems( Request $request ) {

		if ( !$data = json_decode( $request->data ) ) {
			abort( 404, 'Menu items data are not well-formed' );
		}

		foreach( $data as $i => $item) {
			if ( $menuItem = MenuItem::find( $item->id ) ) {
				$menuItem->display_order = $i + 1;
				$menuItem->save();
			}
		}

	}

	/**
	 * @param $menu_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create( $menu_id ) {
		$pages = PageRepository::instance()->getPageTitles();

		$action = 'create';

		return view( toolbox()->backend()->view( 'menus.edit' ), compact( 'menu_id', 'pages', 'action' ) );
	}

	/**
	 * @param MenuItemCreateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( MenuItemCreateRequest $request ) {

		$data = $request->except( ['_token', 'page', 'url'] + ['value' => $this->formValue( $request )]);
		if ( $data['type'] == 'slug') {
			if ( !$page = $this->pageRepository->findById( request( 'page' )) )
				$data[ 'value' ] = '';
			else
				$data['value'] = $page->slug;
		} else {
			$data[ 'value' ] = request( 'url' );
		}

		$menuItem = MenuItem::create( $data );

		return redirect( route( 'admin.menus.manage' ) )->with( 'success', $menuItem->title . ' menu has been added.' );
	}



	/**
	 * @param $menuItemId
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function edit( $menuItemId ) {
		if ( !$menuItem = MenuItem::find( $menuItemId ) ) {
			return redirect( route( 'admin.menus.manage' ) )->with( 'error', 'Unable to find requested item.' );
		}

		$menu_id = $menuItem->menu_id;
		$pages = PageRepository::instance()->getPageTitles();
		$action = 'edit';

		return view( toolbox()->backend()->view( 'menus.edit' ), compact( 'action', 'menu_id', 'menuItem', 'pages' ) );
	}



	/**
	 * @param MenuItemUpdateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( MenuItemUpdateRequest $request ) {

		if ( !$menuItem = MenuItem::find( $request->id ) ) {
			return redirect( route( 'admin.menus.manage' ) )->with( 'error', 'Unable to find requested item.' );
		}

		// updating page
		$menuItem->update( $request->except( ['_token'] ) + [ 'value' => $this->formValue( $request )] );

		return redirect( route( 'admin.menus.manage' ) )->with( 'success', $menuItem->title . ' menu item has been updated.' );
	}


	/**
	 * @param $menuItemId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete( $menuItemId ) {
		if ( !$menuItem = MenuItem::find( $menuItemId ) ) {
			return redirect( route( 'admin.menus.manage' ) )->with( 'error', 'Unable to find requested item.' );
		}

		$menuItem->delete();

		return redirect( route( 'admin.menus.manage' ) )->with( 'success', $menuItem->title . ' menu item has been deleted.' );
	}


	/**
	 * @param $request
	 * @return string
	 */
	private function formValue( $request ) {
		if ( $request->type == MenuItem::TYPE_SLUG ) {
			if (!$page = repo()->page()->findById( $request->page )) {
				return '';
			}
			return $page->slug;
		}
		else if ( $request->type == MenuItem::TYPE_URL ) {
			return $request->url;
		}
		else {
			throw new RuntimeException('Invalid type value');
		}
	}
}

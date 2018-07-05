<?php
namespace App\Models\Repositories\Eloquent;

use App\Models\Category;
use App\Models\Package;
use App\Models\Page;
use App\Models\Repositories\PageRepositoryInterface;
use App\Models\Service;

class PageRepository extends AbstractRepository implements PageRepositoryInterface {

	private $page;

	/**
	 * PageRepository constructor.
	 * @param Page $page
	 */
	public function __construct( Page $page ) {
		parent::__construct( $page );
		$this->page = $page;
	}


	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return PageRepository|null
	 */
	public static function instance( $new=false, $attributes=[] ) {
		static $instance = null;
		if ( is_null($instance) || $new ) {
			$page = new Page($attributes);
			$instance = new PageRepository( $page );
		}
		return $instance;
	}

	/**
	 * @param $slug
	 * @return mixed
	 */
	public function getBySlug( $slug ) {
		return $this->page = $this->model->where( 'slug', trim( $slug, '/' ) )->first();
	}

	/**
	 * @param null $page_id
	 * @param int $active
	 * @return bool
	 */
	public function getServices( $page_id=null, $active=1 ) {
		$page = is_null( $page_id ) ? $this->page : Page::find($page_id);
		if ( !$page ) {
			return false;
		}
		return $page->services()->where('page_services.active', $active)->orderBy( 'page_services.display_order' )->get();
	}


	/**
	 *
	 * @return array|bool|\Illuminate\Support\Collection|mixed|null
	 */
	public function getPackages() {

		if ( !$this->page ) {
			return false;
		}

		$packages = null;
		if ( $this->page->isCategoryPage()) {

			// Selecting each cheapest service from category services.
			if ($this->page->has( 'category' ) && $this->page->category->has( 'packages' )) {
				$category = Category::find( $this->page->category->id );
				if ( $category && $category->has('packages') ) {
					if ( $categoryPackages = $category->packages()->active()->orderBy( 'price' )->get() ) {
						// finding cheapest service of each category
						$categoryPackages = $categoryPackages->groupBy( 'service_id' );
						foreach ($categoryPackages as $categoryPackage) {
							$packages [] = $categoryPackage[0];
						}
						$packages = collect( $packages );
					}
					//dump( $packages[0]->toArray() );
				}

			}
		}
		else if ( $this->page->isServicePage()) {
			if ( $this->page->has( 'service' ) && $this->page->service->has('packages') ) {
				$packages = $this->page->service->packages()->with(
					['features' => function ( $sql ) {
						$sql->orderBy( 'display_order' );
					}
					])->get();
			}
		}
		else if ( $this->page->has( 'packages' )) {
			$packages = $this->page->packages;
		}

		return $packages;
	}

	public function getPageTitles() {
		if ( !$result = $this->getModel()->select('id', 'heading')->orderBy('heading')->get() ) {
			return null;
		}
		return json_decode( $result->toJson() );
	}

}
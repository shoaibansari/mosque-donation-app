<?php 
namespace App\Models\Repositories\Eloquent;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Repositories\MenuRepositoryInterface;

class MenuRepository extends AbstractRepository implements MenuRepositoryInterface
{

	/**
	 * ContactUsRepository constructor.
	 * @param Menu $menu
	 */
    public function __construct(Menu $menu) {
    	parent::__construct( $menu );
    }

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return MenuRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if (is_null( $instance ) || $new) {
			$menu = new Menu( $attributes );
			$instance = new MenuRepository( $menu );
		}
		return $instance;
	}

	/**
	 * Get menus
	 *
	 * @param bool $active
	 * @return \Illuminate\Support\Collection
	 */
	public function getMenus( $active=true ) {
		$menus = [
			'header' => Menu::TYPE_HEADER,
			'footer' => Menu::TYPE_FOOTER,
		];

		foreach( $menus as $name => $menu_id ) {
			$menus [ $name ] = $this->getMenuById( $menu_id, $active );
		}

		return collect($menus);
	}

	/**
	 * Get menu ID by name
	 *
	 * @param $name
	 * @return bool|mixed
	 */
	public function getId( $name ) {
		if (!$menu = $this->getModel()->where('name', $name)->first()) {
			return false;
		}
		return $menu->id;
	}

//	public function getMenusWithColumns( $active = true, $columns = ['id', 'title'] ) {
//		$menus = $this->getMenus( $active );
//		foreach ( $menus as &$menu ) {
//			if ( !$menu ) {
//				continue;
//			}
//
//			$menu = $menu->toJson();
//			dump( $menu );
//		}
//
//		return $menus;
//	}

	/**
	 * @param $menu_id
	 * @param null $active
	 * @return array
	 */
	public function getMenuById( $menu_id, $active=null ) {
		if ( $active )
			$menu = $this->model->active()->find( $menu_id );
    	else
			$menu = $this->model->find( $menu_id );
    	if ( !$menu ) {
    		return [];
	    }
		if ( $active )
			$menuItems = $menu->items()->active()->orderBy( 'display_order' )->get();
    	else
    		$menuItems = $menu->items()->orderBy('display_order')->get();

    	if ( $menuItems && $menuItems->count() == 0 )
    		return [];

    	return $menuItems;
    }


	/**
	 * @param $menu_item_id
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
    public function getMenuItemById( $menu_item_id ) {
		return MenuItem::find( $menu_item_id );
    }

}

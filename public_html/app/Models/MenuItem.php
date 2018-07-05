<?php

namespace App\Models;

use App\Models\Repositories\Eloquent\PageRepository;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
	const TYPE_SITE_ROOT = 'site_root';
	const TYPE_PAGE = 'page';
	const TYPE_CATEGORY = 'category';
	const TYPE_SERVICE = 'service';
	const TYPE_URL = 'url';
	const TYPE_SLUG = 'slug';

	protected $fillable = [ 'id', 'title', 'parent_id', 'menu_id', 'type', 'value', 'active', 'visibility', 'display_order'];
	protected $appends = [ 'page', 'url' ];

    public function menu() {
    	return $this->belongsTo( Menu::class );
    }

    public function items() {
    	return $this->hasMany( MenuItem::class, 'parent_id' );
    }

	public function scopeActive( $query ) {
		return $query->where( 'active', 1 );
	}


	public function url() {

		$slug = '';
    	$value = trim($this->value);

		if ( empty($value) ) {
			return '';
		}

		// URL
    	if ( $this->type == self::TYPE_URL ) {
    		return $value;
	    }

	    // SITE ROOT
		if ($this->type == self::TYPE_SITE_ROOT) {
			return toolbox()->frontend()->url( '' );
		}


		// SLUG
		if ($this->type == self::TYPE_SLUG) {
			return toolbox()->frontend()->url( $value );
		}

		// PAGE
		if ( $this->type == self::TYPE_PAGE ) {
    		$page = Page::select('slug')->find( $value );   // TODO:: Query optimization may required here.
    		if ( !$page ) {
    			return '';
		    }
		    $slug = $page->slug;
	    }

	    // CATEGORY
	    else if ( $this->type == self::TYPE_CATEGORY ) {
    		if ( !$category = Category::select('slug')->find( $value ) ) {
    			return null;
		    }
		    return $category->getUrl();
	    }

	    // SERVICES
	    else if ( $this->type == self::TYPE_SERVICE ) {
    		if ( !$service = Service::select('slug')->find( $value ) ) {
    			return null;
		    }
		    return $service->getUrl();
	    }


		if ( !$slug ) {
	    	return '';
		}

		return toolbox()->frontend()->url( $slug );

	}

	public function getPageAttribute() {
		if ( $this->type == self::TYPE_SLUG ) {
			if ( $page = PageRepository::instance()->getBySlug( $this->value ) ) {
				return $page->id;
			}
		}

		return '';
	}

	public function getUrlAttribute() {
		if ( $this->type == self::TYPE_URL ) {
			return $this->value;
		}

		return '';
	}


}

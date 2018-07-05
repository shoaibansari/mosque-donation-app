<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Page extends Model {

	const SLUG_CONTACT_US = 'contact-us';
	const SLUG_TERMS_OF_USE = 'terms-of-use';
	const SLUG_PRIVACY_POLICY = 'privacy-policy';
	const SLUG_SITEMAP = 'sitemap';
	const SLUG_ORDER_NOW = 'order-now';

    public function __construct( array $attributes = [] ) {
	    parent::__construct( $attributes );
	    $this->uploadPath = storage_path( '/uploads/app/pages/' );
	    $this->uploadUrl = toolbox()->frontend()->url( 'uploads/app/pages/' ) . '/';
    }

	/*
	 * -------------------------------------------------
	 * Relationships
	 * -------------------------------------------------
	 */

    public function slider() {
    	return $this->hasOne( Slider::class );
    }


    /*
     * -------------------------------------------------
     * Scopes
     * -------------------------------------------------
     */

    public function scopePublished( $query ) {
		return $query->where('published', 1);
	}



	/*
     * -------------------------------------------------
     * Attributes
     * -------------------------------------------------
     */

	/**
	 * Published At
	 * @param  string $value
	 * @return string
	 */
	public function getPublishedAtAttribute( $value ) {
		return Carbon::parse( $value )->format( 'M j, Y' ); // e.g. Jan 28, 2017
	}

	public function getCreatedAtAttribute( $value ) {
		return Carbon::parse( $value )->format( 'M j, Y H:i' ); // e.g. Jan 28, 2017
	}

	public function getUpdatedAtAttribute( $value ) {
		return Carbon::parse( $value )->format( 'M j, Y H:i' ); // e.g. Jan 28, 2017
	}



	/*
     * -------------------------------------------------
     * Others
     * -------------------------------------------------
     */

	public function getUrl() {
		$slug = !$this->slug ? toolbox()->url()->formatSlug( $this->title ) : $this->slug;
		return toolbox()->frontend()->url( $slug );
	}


	public function isCategoryPage() {
		return Category::whereSlug( trim( $this->slug ) )->count() > 0;
	}

	public function isServicePage() {
		return Service::whereSlug( trim( $this->slug ) )->count() > 0;
	}

	public function isSitemapPage() {
		return strtolower(trim($this->slug)) == strtolower(trim( self::SLUG_SITEMAP, '/'));
	}

	public function isContactUs() {
		return strtolower( trim( $this->slug ) ) == strtolower( trim( self::SLUG_CONTACT_US, '/' ) );
	}

	public function hasBanner() {
		return !empty($this->banner);
	}

	public function bannerExists() {
		if ( !$this->hasBanner() ) {
			return false;
		}

		$banner = $this->uploadPath . $this->banner;
		if ( is_dir( $banner ) ) {
			return false;
		}

		return file_exists( $banner );
	}

	public function bannerImageUrl() {
		if ( !$this->bannerExists() )
			return null;

		return $this->uploadUrl . $this->banner;
	}

	/*
	 * -------------------------------------------------
	 * Properties
	 * -------------------------------------------------
	 */
	protected $uploadPath, $uploadUrl;

	protected $fillable = [
		'slug',
		'slug_editable',
		'banner',
		'background',
		'heading',
		'abstract',
		'contents',
		//'header_contents',
		//'footer_contents',
		'meta_title',
		'meta_keywords',
		'meta_description',
		'published',
		'published_at'
	];


}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
	protected $fillable = array('author_id', 'category_id', 'type', 'title', 'content', 'slug', 'photo', 'banner', 'allow_comments');

	/**
	 * @param $value
	 * @return array|bool
	 */
	public function getTagsAttribute( $value ) {
		if ( empty($value) ) {
			return false;
		}

		$value = explode(",", $value);
		array_walk( $value, function($item) {
			return ucwords(trim($item));    // removing extra spaces and making upper case words
		});

		return array_unique($value);
	}

	public function scopePublished( $query ) {
		return $query->where('published', 1);
	}


	/**
	 * Published At
	 * @param  string $value
	 * @return string
	 */
	public function getPublishedAtAttribute( $value ) {
		return Carbon::parse($value)->format( 'M j, Y'); // e.g. Jan 28, 2017
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author() {
		return $this->belongsTo( User::class, 'author_id' );
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function category() {
		return $this->belongsTo( Category::class );
	}


	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	public function url() {
		$slug = 'blog/';
		$slug .= toolbox()->url()->formatSlug( (empty($this->slug) ? $this->title : $this->slug) ) . '-p' . $this->id;
		return toolbox()->frontend()->url( $slug );
	}

	public function thumbnailUrl() {
		if (!$this->thumbnail) {
			return false;
		}

		return toolbox()->frontend()->asset( '/img/blog/' . $this->id . '/' . $this->thumbnail . '?v=' . $this->updated_at->timestamp );
	}

	public function hasBanner() {
		return !empty( $this->banner );
	}

	public function bannerUrl() {
		if ( !$this->banner ) {
			return false;
		}

		return toolbox()->frontend()->asset( '/img/blog/' . $this->id . '/' . $this->banner . '?v=' . $this->updated_at->timestamp );
	}





}

<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 11/15/2017 11:33 PM
 */

namespace App\Models\Repositories\Eloquent;
use App\Models\Repositories\VideoRepositoryInterface;
use App\Models\Video;
use App\Models\VideoView;

class VideoRepository extends AbstractRepository implements VideoRepositoryInterface {



	public function __construct( Video $video ) {
		parent::__construct( $video );
	}

	/**
	 * @param bool $new
	 * @param array $attributes
	 * @return VideoRepository
	 */
	public static function instance( $new = false, $attributes = [] ) {
		static $instance = null;
		if ( is_null( $instance ) || $new ) {
			$video = new Video( $attributes );
			$instance = new VideoRepository( $video );
		}

		return $instance;
	}


	public function getFeaturedVideos( $limit=4 ) {


		$featuredVideos = $this->model->featured(1)->active(1);
		$featuredVideosCount = $featuredVideos->count();

		$findMoreVideos = 0;
		if ( $featuredVideosCount < $limit ) {
			$findMoreVideos = $limit - $featuredVideosCount;
		}

		$videos = null;
		if ( !$findMoreVideos ) {

			$videos = $featuredVideos->orderBy( 'created_at', 'desc' )->get();

		} else {

			$featuredIds = null;
			if ( $featuredVideosCount > 0 ) {
				$featuredIds = $featuredVideos->get()->pluck( 'id' )->toArray();
			}

			$otherVideos = null;
			if ( $featuredIds ) {
				$otherVideos = $this->model->whereNotIn('id', $featuredIds )->take( $findMoreVideos );
			}
			else {
				$otherVideos = $this->model->take( $findMoreVideos );
			}

			if ( $featuredVideosCount > 0 ) {
				$videos = $featuredVideos->orderBy('created_at', 'desc')->get();
			}

			if ( $otherVideos->count() > 0 ) {
				if( $videos )
					$videos = $videos->merge( $otherVideos->orderBy( 'created_at', 'desc' )->get() );
				else
					$videos = $otherVideos->get();
			}

		}

		return $videos;
	}

	public function getRecommendedVideos( $video, $limit=10 ) {
		return $this->getFeaturedVideos( $limit ); // temporally
	}

	public function getNewKey() {
		while ( true ) {
			$key = toolbox()->string()->randomHash();
			if ( !$this->isKeyExist( $key ) ) {
				return $key;
			}
		}
	}

	public function getViews( $video, $user=null, $formatted=true ) {
		if ( !$video ) {
			return false;
		}

		if ( is_scalar( $video ) ) {
			if ( !$video = $this->model->find( $video ) ) {
				return false;
			}
		}

		if ( $user ) {
			if ( !is_scalar( $user ) ) {
				$user = $user->id;
			}
			$views = $video->views()->whereUserId( $user )->sum( 'view_count' );
		}
		else {
			$views = $video->views()->sum( 'view_count' );
		}


		if ( $formatted )
			return number_format( $views );

		return $views;
	}

	public function incrementInViews( $video, $user=null ) {
		if ( !$video ) {
			return false;
		}

		if ( is_scalar( $video ) ) {
			if ( !$video = $this->model->find( $video ) ) {
				return false;
			}
		}

		if ( $user ) {
			if ( !is_scalar( $user ) ) {
				$user = $user->id;
			}
		}


		$viewsCount = $this->getViews( $video, $user, false ) + 1;
		$videoView = null;
		if ( $user ) {
			if ( !$videoView = VideoView::whereUserId( $user->id )->whereVideoId( $video->id )->first() ) {
				if ( $videoView = VideoView::create(
					[
					'user_id' => $user->id,
					'video_id' => $video->id,
					'view_count' => $viewsCount
				]) ) {
					return true;
				}
			}
		}

		if ( !$videoView ) {
			if ( !$videoView = VideoView::whereVideoId( $video->id )->first() ) {
				if ( $videoView = VideoView::create(
					[
						'user_id'    => 0,
						'video_id'   => $video->id,
						'view_count' => $viewsCount
					]
				) ) {
					return true;
				}
			}
		}

		$videoView->view_count = $viewsCount;
		$videoView->save();

		return true;
	}

	public function isKeyExist( $key ) {
		return $this->getModel()->where('key', $key )->count() > 0;
	}




}
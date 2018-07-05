<?php

namespace App\Models;

use App\Models\Repositories\Eloquent\LocationPhotoRepository;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LocationPhoto extends Model {

	protected $fillable = [
		'job_id',
		'location_id',
		'filename',
		'filesize',
		'camera_number',
		'created_at',
		'updated_at'
	];

	protected $storagePath, $baseUrl;


	public function __construct( array $attributes = [] ) {
		parent::__construct( $attributes );
		$this->storagePath( storage_path( 'app/public/location-photos' ) );
	}

	public function storagePath( $storagePath ) {
		$this->storagePath =$storagePath;
		$path = str_replace( storage_path( 'app'), '', $this->storagePath);
		$this->baseUrl = toolbox()->frontend()->url( 'uploads/') . $path;
	}
	
	public function job() {
		return $this->belongsTo( Job::class );
	}

	public function location() {
		return $this->belongsTo( UserLocation::class );
	}

//	public function area() {
//		return $this->belongsToMany( Job::class, 'job_location_photos', 'job_id', 'location_id' );
//	}
	
	public function violations() {
		return $this->hasMany( LocationViolation::class, 'photo_id' );
	}

	public function getStoragePath() {
		return $this->storagePath;
	}

	public function getImagePath() {
		return $this->storagePath . '/' . $this->filename;
	}

	public function getImageUrl() {
		return $this->baseUrl . '/' . $this->filename;
	}
	
	public function getImageDimensions() {
		return toolbox()->image( $this->getImagePath() )->getDimensions();
	}

	public function getResizedImageUrl( $width = 150, $height = 120 ) {
		// the image url will return from the cache, after resizing
		return toolbox()->image( $this->getImagePath() )->resize( $width, $height, 'F' )->getUrl();
	}
	
	public function imageExists() {
		return toolbox()->file()->exists( $this->getImagePath() );
	}


}

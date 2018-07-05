<?php namespace App\Classes\CToolBox;

use App\Models\Repositories\Eloquent\CountryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CImageTool {

	protected $imagePath, $quality, $altPath, $altUrl, $basePath, $cache, $cachePath, $resetCache;
	protected $baseURL, $width, $height, $scale, $resizeMode;

	/**
	 * @param null $imagePath
	 * @param bool $cache
	 * @return CImageTool
	 */
	public static function instance( $imagePath = null, $cache = true ) {
		static $instance;
		if ( !$instance ) {
			$instance = new CImageTool();
			$instance->basePath( storage_path() . '/app' );
			$instance->baseURL( toolbox()->frontend()->url( '/uploads/' ) );
			$instance->cachePath( storage_path() . '/app/public/cache' );
			$instance->cache( $cache );
			$instance->quality( 90 );
			
		}
		$instance->file( $imagePath );

		return $instance;
	}
	
	/**
	 * Create image file using base64 string.
	 *
	 * @param $filepath
	 * @param $base64_contents
	 * @return bool|int
	 */
	public function createFileFromBase64( $filepath, $base64_contents, $quality=80 ) {
		$pos = (strpos($base64_contents, 'base64,') + 7);
		$contents = base64_decode(substr($base64_contents, $pos));
		return file_put_contents($filepath, $contents);
	}

	public function file( $imagePath ) {
		$this->imagePath = preg_replace('/\/{2,}/', '/', $imagePath);
		return $this;
	}

	public function basePath( $storagePath ) {
		$this->basePath = rtrim( $storagePath, "/" );

		return $this;
	}

	public function baseURL( $url ) {
		$this->baseURL = $url;
		return $this;
	}

	public function cache( $status = true ) {
		$this->cache = $status;

		return $this;
	}

	/**
	 * Reset cache
	 *
	 * @param bool $status
	 * @return $this
	 */
	public function reset( $status = true ) {
		$this->resetCache = $status;

		return $this;
	}

	public function cachePath( $directoryPath ) {
		$this->cachePath = $directoryPath;

		return $this;
	}

	/**
	 * If image not exist then alternate image will return.
	 *
	 * @param $imagePath
	 * @return $this
	 */
	public function altFile( $imagePath ) {
		$this->altPath = $imagePath;
		$this->altUrl = null;

		return $this;
	}

	/**
	 * If image not exist then alternate image will return.
	 *
	 * @param $imageUrl
	 * @return $this
	 */
	public function altUrl( $imageUrl ) {
		$this->altUrl = $imageUrl;
		$this->altPath = null;

		return $this;
	}

	/**
	 *
	 * @param $width
	 * @param $height
	 * @param string $scale "e"=EXACT, "f"=FIT, "p"=ASPECT RATIO
	 * @return $this
	 */
	public function resize( $width, $height, $scale = 'f' ) {
		$this->resizeMode = true;
		$this->width = $width;
		$this->height = $height;
		$this->scale = $scale;

		return $this;
	}

	public function quality( $quality ) {
		$this->quality = $quality;

		return $this;
	}
	
	public function getDimensions( $imagePath=null ) {
		$imagePath = is_null($imagePath) ? $this->imagePath : $imagePath;
		if ( !toolbox()->file()->exists($imagePath) ) {
			return false;
		}
		list($width, $height) = getimagesize($imagePath);
		return [ 'width' => $width, 'height' => $height ];
	}
	
	public function save( $quality=90, $dstPath = null ) {
		
		if( !toolbox()->file()->exists($this->imagePath)) {
			$info = env('APP_DEBUG' ) ? '. Path: ' . $this->imagePath : ".";
			throw new \Exception( 'Image does not exist' . $info );
		}
		
		if ( !$dstPath ) {
 			$dstPath = $this->imagePath;
		}
		
		// if resize method is not called before, so applying original settings.
		if ( !$this->resizeMode ) {
			$dims = $this->getDimensions( $this->imagePath );
			$this->width = $dims['width'];
			$this->height = $dims['height'];
			$this->scale = 'p';
		}
		
		return $this->resizeFile(
			$this->imagePath,
			$this->width,
			$this->height,
			$this->scale,
			'file',
			$dstPath,
			$quality
		);
		
	}

	public function getUrl() {

		$imagePath = null;
		if ( toolbox()->file()->exists( $this->imagePath ) ) {
			$imagePath = $this->imagePath;
		}
		else if ( !is_null( $this->altPath ) && toolbox()->file()->exists( $this->altPath ) ) {
			$imagePath = $this->altPath;
		}

		// if image not exist then alternate-url will return.
		if ( !$imagePath ) {
			if ( !$this->altUrl ) {
				throw new \Exception( 'Image does not exist neither alternate image has specified.' );
			}

			return rtrim( $this->baseURL, '/' ) . '/' . ltrim( $this->altUrl, '/' );
		}
		
		
		if ( $this->resetCache ) {
			$this->clearCache( $imagePath );
		}

		$cacheFile = null;
		if ( $this->cache ) {
			
			\Log::debug('Actual file:' . $imagePath);

			$cacheFile = $this->getCacheFile( $imagePath );
			$cacheDir = dirname( $cacheFile );
			\Log::debug( 'Cache file:' . $cacheFile );
			//dump(['imagePath'=> $imagePath,'file' => $cacheFile, 'dir' => $cacheDir]);
			if ( !toolbox()->filesystem()->createPath( $cacheDir ) ) {
				throw new \Exception( 'Unable to create cache directory.' );
			}
			
			
			if ( $cachedFile = $this->isCacheFileExists( $imagePath ) ) {
				\Log::debug('Cache file exist: true');
				
				return $this->getCachedFileUrl( $cachedFile );
			}
			\Log::debug('Cache file exist: false');

			// updating imagePath with cacheFile
			$cacheFile = $this->getCacheFile( $imagePath );
			\Log::debug('Created cache file: ' . $cacheFile );
		}

		// if width is specified then it means to resize the image
		if ( $this->resizeMode ) {
			$this->resizeFile(
				$imagePath,
				$this->width,
				$this->height,
				$this->scale,
				'file',
				$cacheFile ? $cacheFile : $imagePath,
				$this->quality
			);
		}

		if ( $cacheFile ) {
			return $this->getCacheFileUrl( $imagePath );
		}

		// removing storage_path from the imagePath to format a URL
		$imagePath = $this->getRelativePath( $imagePath );

		return $this->baseURL . $imagePath;

	}

	public function get( $options = [] ) {
		$attributes = [];
		if ( $options && is_array( $options ) ) {
			foreach ( $options as $prop => $value )
				$attributes[] = $prop . '="' . $value . '"';
		}
		$attributes = implode( "", $attributes );

		return '<img src="' . $this->getUrl() . '" ' . $attributes . ' />';
	}

	/**
	 * @param $imagePath
	 * @param $width
	 * @param $height
	 * @param string $scaleType "r" for proportional resize, "e" for exact and "f" for fit
	 * @param string $output "flush" = Draw Image on browser, "file" = save in file, requires "save_as" parameter, "object" = return canvas
	 * @param string $save_as
	 * @param int $quality
	 * @return bool
	 * @throws \Exception
	 */
	public function resizeFile( $imagePath, $width, $height, $scaleType = "e", $output = "flush", $save_as = "", $quality = 90 ) {

		if ( empty( $imagePath ) || !file_exists( $imagePath ) || is_dir( $imagePath ) ) {
			throw new \Exception( 'No image found.' );
		}

		list( $src_width, $src_height, $src_type ) = getimagesize( $imagePath );
		$source_image = null;
		switch ( $src_type ) {
			case IMAGETYPE_GIF:
				$source_image = imagecreatefromgif( $imagePath );
				break;
			case IMAGETYPE_JPEG:
				$source_image = imagecreatefromjpeg( $imagePath );
				break;
			case IMAGETYPE_PNG:
				$source_image = imagecreatefrompng( $imagePath );
				break;
		}

		$output = strtolower( $output );
		$scaleType = strtolower( $scaleType );

		list( $final_width, $final_height ) = $this->calculateDimensions($scaleType, $src_width, $src_height, $width, $height );
		
		toolbox()->log()->debug('Final: '. $final_width . 'x' . $final_height);
		$canvas = $this->getCanvas( $source_image, $src_type, $final_width, $final_height );

		// Resizing image
		imagecopyresampled( $canvas, $source_image, 0, 0, 0, 0, $final_width, $final_height, $src_width, $src_height );

		// if scale type is FIT
		if ( $scaleType == 'f' ) {

			$dst_x = 0;
			$dst_y = 0;
			$src_x = ($final_width - $width) / 2;
			$src_y = ($final_height - $height) / 2;
			$newCanvas = $this->getCanvas( $source_image, $src_type, $width, $height );
			imagecopy( $newCanvas, $canvas, $dst_x, $dst_y, $src_x, $src_y, $width, $height);
			$canvas = $newCanvas;
			//imagedestroy( $newCanvas );
		}

		// Output
		if ( $output == "flush" ) {
			$mime = image_type_to_mime_type( $src_type );
			header( "Content-type: $mime" );
			$output = null;
		}
		else if ( $output == "file" ) {

			$output = $save_as;
			if ( empty( $output ) ) {
				return false;
			}

		}
		else if ( $output == "object" ) {
			return $canvas;
		}

		switch ( $src_type ) {
			case IMAGETYPE_GIF:
				imagegif( $canvas, $output );
				break;
			case IMAGETYPE_JPEG:
				imagejpeg( $canvas, $output, $quality );
				break;
			case IMAGETYPE_PNG:
				imagepng( $canvas, $output );
				break;
			default:
				return false;
		}
		imagedestroy( $canvas );

		return true;
	}

	private function getCanvas( $image, $imageType, $width, $height) {

		// Create a new canvas
		if ( $imageType == IMAGETYPE_GIF ) {
			$canvas = imagecreate( $width, $height );
		}
		else {
			$canvas = imagecreatetruecolor( $width, $height );
		}

		// Preserve transparency
		if ( $image && $imageType == IMAGETYPE_GIF ) {
			$transparentColor = imagecolortransparent( $image );
			if ( $transparentColor >= 0 ) {
				$colorsForIndex = imagecolorsforindex( $image, $transparentColor );
				$transparentColor = imagecolorallocate( $canvas, $colorsForIndex[ 'red' ], $colorsForIndex[ 'green' ], $colorsForIndex[ 'blue' ] );
				imagefill( $canvas, 0, 0, $transparentColor );
				imagecolortransparent( $canvas, $transparentColor );
			}
		}
		else if ( $imageType == IMAGETYPE_PNG ) {
			imagealphablending( $canvas, false );
			$color = imagecolorallocatealpha( $canvas, 0, 0, 0, 127 );
			imagefill( $canvas, 0, 0, $color );
			imagesavealpha( $canvas, true );
		}

		return $canvas;

	}

	private function getCacheFilename( $imagePath, $withSize = true, $withTime = true, $withExt = true ) {
		$fileInfo = pathinfo( $imagePath );
		$parts = [];
		$parts[] = toolbox()->file()->formatName( $fileInfo[ 'filename' ], '-', false );
		if ( $withSize ) {
			$parts[] = $this->width . 'x' . $this->height;
		}
		if ( $withTime ) {
			$parts[] = time();
		}
		$fileName = implode( "-", $parts );
		if ( $withExt ) {
			$fileName .= '.' . $fileInfo[ 'extension' ];
		}

		return $fileName;
	}

	private function clearCache( $imagePath ) {
		$cacheFilePrefix = $this->getCacheFilename( $imagePath, false, false, false );
		$cachePath = dirname( $this->getCacheFile( $imagePath ) );
		if ( !file_exists( $cachePath ) ) {
			return false;
		}
		$files = toolbox()->filesystem()->getFiles( $cachePath, $cacheFilePrefix );
		if ( count( $files ) ) {
			foreach ( $files as $file ) {
				if ( !is_dir( $file ) && is_writable( $file ) ) {
					unlink( $file );
				}
			}
		}
	}

	private function getCacheFile( $imagePath ) {
		$imagePath = $this->getRelativePath( $imagePath );
		\Log::debug('Relative Path:' . $imagePath);
		$cachePath = rtrim( $this->cachePath ) . '/' . trim( dirname( $imagePath ), '/' );

		return $cachePath . '/' . $this->getCacheFilename( $imagePath, true, false, true );
	}

	private function getRelativePath( $imagePath ) {
		return '/' . ltrim( str_replace( $this->basePath, '', $imagePath ), '/' );
	}

	private function isCacheFileExists( $imagePath ) {

		$cacheFilePrefix = $this->getCacheFilename( $imagePath, true, false, false );
		$cachePath = dirname( $this->getCacheFile( $imagePath ) );
		if ( !file_exists( $cachePath ) ) {
			return false;
		}
		$files = toolbox()->filesystem()->getFiles( $cachePath, $cacheFilePrefix );
		if ( !count( $files ) ) {
			return false;
		}

		return $files[ 0 ];
		//return toolbox()->file()->exists( $this->getCacheFile( $imagePath ) );
	}

	private function getCachedFileUrl( $imagePath ) {
		$cacheFile = basename( $imagePath );
		$cachePath = str_replace( $this->basePath, '', dirname( $imagePath ) );

		return rtrim( $this->baseURL,'/') . '/' . $cachePath . '/' . $cacheFile;
	}

	private function getCacheFileUrl( $imagePath ) {
		$cacheFile = $this->getCacheFilename( $imagePath, true, false, true );
		$cachePath = str_replace( $this->basePath, '', $this->cachePath );
		$cacheRelativePath = $this->baseURL . $cachePath . dirname( $this->getRelativePath( $imagePath ) );

		return $cacheRelativePath . '/' . $cacheFile;
	}



	/**
	 *
	 * @param $type
	 * @param $actualWidth
	 * @param $actualHeight
	 * @param $requiredWidth
	 * @param $requiredHeight
	 * @return array [width, height]
	 */
	private function calculateDimensions($type, $actualWidth, $actualHeight, $requiredWidth, $requiredHeight ) {

		if ( !$requiredWidth && !$requiredHeight ) {
			return [$actualWidth, $actualHeight];
		}

		switch ( $type ) {

			case 'f':
			case 'fit':
				$actualFactor = $actualWidth / $actualHeight;
				$requiredFactor = $requiredWidth / $requiredHeight;
				if ( $actualFactor > $requiredFactor ) {
					// when source image is wider
					return [$actualHeight, (int)($actualHeight * $actualFactor)];
				}
				else {
					// source image is similar or taller
					return [$requiredWidth, (int)($requiredWidth / $actualFactor)];
				}
				break;

			case 'r':
			case 'ratio':
				if($requiredWidth == 0) {
					$factor = $actualWidth / $actualHeight;
					$width = $requiredHeight / $factor;
					$height = $requiredHeight;
				}
				else if($requiredHeight == 0) {
					$factor = $actualWidth / $actualHeight;
					$width = $requiredWidth;
					$height = $requiredWidth / $factor;
				}
				else {
					$factor = min($requiredWidth / $actualWidth, $requiredHeight / $actualHeight);
					$width = $requiredWidth * $factor;
					$height = $requiredHeight * $factor;
				}
				return [ round($width), round($height) ];
				

			case 'e':
			case 'exact':
			default:
				return [$requiredWidth, $requiredHeight];

		}
	}
}

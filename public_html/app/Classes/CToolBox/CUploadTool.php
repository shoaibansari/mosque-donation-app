<?php
/**
 * Created by PhpStorm.
 * User: Muhammad Adnan
 * Date: 11/28/2016
 * Time: 12:48 AM
 */

namespace App\Classes\CToolBox;

class CUploadTool {

	const NO_ERROR = 0;
	const ERR_NO_FILE_UPLOAD = 404;
	const ERR_STORAGE_NOT_WRITABLE = 405;
	const ERR_UNABLE_TO_MOVE_FILE = 406;
	const ERR_FILE_SIZE_EXCEEDS = 407;
	const ERR_FILE_TYPE_NOT_ALLOWED = 408;

	private $errorsMap = [];

	/**
	 * @param string $field
	 * @param string $storagePath
	 * @param bool $ignoreDangerousFiles
	 * @return CUploadTool
	 */
	public static function instance( $field = '', $storagePath = '', $ignoreDangerousFiles = true ) {
		static $instance;
		if (!$instance) {
			$instance = new CUploadTool( $field, $storagePath, $ignoreDangerousFiles );
		}

		return $instance;
	}

	/**
	 * CUploadTool constructor.
	 * @param string $field
	 * @param string $storagePath
	 * @param bool $ignoreDangerousFiles
	 */
	public function __construct( $field = '', $storagePath = '', $ignoreDangerousFiles = true ) {
		$this->field = $field;
		$this->storagePath( $storagePath );
		$this->ignoreDangerousFiles = $ignoreDangerousFiles;
		$this->allowedFileSize = CServerTool::instance()->uploadFileSizeLimit();
		$this->errorsMap = [
			self::ERR_NO_FILE_UPLOAD        => trans( 'toolbox.upload.err_no_file_found' ),
			self::ERR_STORAGE_NOT_WRITABLE  => trans( 'toolbox.upload.err_destination_not_writable' ),
			self::ERR_UNABLE_TO_MOVE_FILE   => trans( 'toolbox.upload.err_unable_to_move_file' ),
			self::ERR_FILE_SIZE_EXCEEDS     => trans( 'toolbox.upload.err_file_size_exceed' ),
			self::ERR_FILE_TYPE_NOT_ALLOWED => trans( 'toolbox.upload.err_invalid_file_type' ),
		];
	}

	public function field( $field ) {
		$this->field = $field;

		return $this;
	}

	public function storagePath( $storagePath ) {
		$this->storagePath = rtrim( rtrim( $storagePath, '\\' ), '/' ) . DIRECTORY_SEPARATOR;

		return $this;
	}

	public function filesPrefix( $prefix ) {
		$this->filesPrefix = $prefix;

		return $this;
	}

	public function filesAllowed( $extensions, $separator = "," ) {
		$this->allowedExtensions = is_array( $extensions ) ? $extensions : explode( $separator, $extensions );

		return $this;
	}

	public function filesNotAllowed( $extensions, $separator = "," ) {
		$this->disallowedExtensions = is_array( $extensions ) ? $extensions : explode( $separator, $extensions );

		return $this;
	}

	public function sizeLimit( $limit ) {
		$this->allowedFileSize = CFileTool::instance()->fileSizeToBytes( $limit );
		return $this;
	}

	public function getSizeLimit( $readable=false ) {
		if ( !$readable )
			return $this->allowedFileSize;
		return CFileTool::instance()->readableFileSize( $this->allowedFileSize, 0 );
	}

	public function hasError() {
		return !empty( $this->error );
	}

	public function getError() {
		return $this->error;
	}

	public function getErrorCode() {
		return $this->errorCode;
	}

	public function validate() {

		$this->error = "";
		$this->errorCode = self::NO_ERROR;
		$this->files = [];

		$files = request()->file( $this->field );
		if (!$files) {
			$this->errorCode = self::ERR_NO_FILE_UPLOAD;
			$this->error = $this->errorsMap[ $this->errorCode ];

			return false;
		}

		if (!is_array( $files )) {
			$files = [$files];
		}

		$error = false;
		foreach ($files as $i => $file) {

			$fileInfo = [
				'name' => $file->getClientOriginalName(),
				'size' => $file->getClientSize(),
				//'mime' => $file->getMimeType(),
				'mime' => $file->getClientMimeType(),
				'ext'  => $file->getClientOriginalExtension(),
			];

			if ($fileInfo['size'] > $this->allowedFileSize) {
				$error = true;
				$fileInfo['errorCode'] = self::ERR_FILE_SIZE_EXCEEDS;
				$fileInfo['error'] = sprintf($this->errorsMap[ self::ERR_FILE_SIZE_EXCEEDS ], CFileTool::instance()->readableFileSize( $this->allowedFileSize ) );
			}
			else if (is_array( $this->disallowedExtensions ) && count( $this->disallowedExtensions ) && in_array( $fileInfo['ext'], $this->disallowedExtensions )) {
				$error = true;
				$fileInfo['errorCode'] = self::ERR_FILE_TYPE_NOT_ALLOWED;
				$fileInfo['error'] = $this->errorsMap[ self::ERR_FILE_TYPE_NOT_ALLOWED ];
			}
			else if (is_array( $this->allowedExtensions ) && count( $this->allowedExtensions ) && !in_array( $fileInfo['ext'], $this->allowedExtensions )) {
				$error = true;
				$fileInfo['errorCode'] = self::ERR_FILE_TYPE_NOT_ALLOWED;
				$fileInfo['error'] = $this->errorsMap[ self::ERR_FILE_TYPE_NOT_ALLOWED ];
			}

			$this->files[ $i ] = $fileInfo;
		}

		// in case of multiple errors, default error point to first file that has an error.
		if ($error) {
			if (is_array( $this->files ) && count( $this->files )) {
				foreach ($this->files as $file) {
					if (isset( $file['error'] )) {
						$this->error = $file['error'];
						$this->errorCode = $file['errorCode'];
						break;
					}
				}
			}
		}

		return !$error;
	}

	public function move() {

		if (!$this->validate()) {
			return false;
		}

		// adding more info in $this->files
		$files = request()->file( $this->field );
		foreach ($files as $i => $file) {

			$saved_as = $this->filesPrefix .
				CFileTool::instance()->formatName( $this->files[ $i ]['name'] );

			$fileInfo['saved_as'] = $saved_as;
			$fileInfo['file'] = $this->storagePath . $saved_as;

			if (!$file->move( $this->storagePath, $fileInfo['saved_as'] )) {
				$this->errorCode = self::ERR_UNABLE_TO_MOVE_FILE;
				$this->error = $this->errorsMap[ $this->errorCode ];
				CLogTool::instance()->error( 'Unable to move file to path: ' . $this->storagePath );

				return false;
			}

			// adding attributes in primary array
			$this->files[ $i ]['md5'] = md5_file( $fileInfo['file'] );
			$this->files[ $i ]['saved_as'] = $fileInfo['saved_as'];
			$this->files[ $i ]['file'] = $fileInfo['file'];
		}

		return true;
	}

	public function get() {
		return $this->files;
	}

	private
		$field,
		$files,
		$filesPrefix = '',
		$storagePath,
		$allowedExtensions,
		$disallowedExtensions,
		$allowedFileSize,
		$ignoreDangerousFiles,
		$error, $errorCode;

}
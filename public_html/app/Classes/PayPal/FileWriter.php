<?php
/*
 *
 */
namespace App\Classes\PayPal;

class FileWriter {

	const MODE_APPEND = 'a';
	const MODE_WRITE = 'w';

	private $fp, $data, $count=0;
	public $maxBufferSize = 1000;
	private $trace = false;
	private $filePath = null, $mode;

	public function __construct($filePath=null, $mode=self::MODE_APPEND, $trace = false) {
		if ( empty($mode))
			$mode = self::MODE_APPEND;
		$this->filePath = $filePath;
		$this->mode = $mode;
		if ($this->filePath)
			$this->open( $this->filePath, $this->mode);
		$this->trace = $trace;
	}

	public function __destruct() {
		$this->close();
	}

	public function getFile() {
		return $this->filePath;
	}

	public function open($filePath, $mode) {
		$this->fp = fopen($filePath, $mode);
		if ( !$this->fp ) {
			throw new Exception("Unable to open file.");
		}
	}

	public function write($data, $trace=false ) {
		if ( !is_scalar($data) ) {
			$data = print_r($data, true);
		}
		if ( $this->trace || $trace ) {
			$bt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
			$caller = array_shift( $bt );
			$fd = str_repeat( "-", 100 ) . PHP_EOL;
			$fd .= sprintf( "%s(%d)%s", $caller['file'], $caller['line'], PHP_EOL );
			$fd .= str_repeat( "-", 100 ) . PHP_EOL;
			$fd .= $data . PHP_EOL . PHP_EOL;
		} else {
			$fd = $data;
		}
		$this->count++;
		$this->data[] = $fd;
		if ( $this->count >= $this->maxBufferSize ) {
			$this->flush();
		}
	}

	public function writeln( $data ) {
		if ( !is_scalar($data) ) {
			$data = print_r($data, true);
		}
		$this->write( $data . PHP_EOL);
	}

	public function getContents() {
		$this->close();
		$contents = file_get_contents( $this->filePath );
		$this->open( $this->filePath, $this->mode );
		return $contents;
	}

	public function renameTo( $dstFile ) {
		$this->close();
		if ( !@rename( $this->filePath, $dstFile ) ) {
			\Log::error('Unable to rename file. src: '. $this->getFile() . ", dst: ".$dstFile);
			return false;
		}
		$this->filePath = $dstFile;
		$this->open( $this->filePath, $this->mode );
		return true;
	}

	public function flush() {
		if (!$this->count)
			return;
		$data = implode("", $this->data);
		fwrite($this->fp, $data);
		$this->data = null;
		$this->count = 0;
	}

	public function close() {
		if ( $this->fp ) {
			$this->flush();
			fclose($this->fp);
			$this->fp = null;
		}
	}

}
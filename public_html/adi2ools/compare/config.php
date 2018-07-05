<?php
$settings_file = "./settings.json";
if ( !file_exists($settings_file) || is_dir($settings_file) ) {
	throw new Exception('settings.json file is missing.');
}

if ( !$settings = @json_decode(file_get_contents($settings_file), true )) {
	throw new Exception('settings.json is either empty or has syntax errors');
}

$settings['sourceDir'] = $settings['auth']['root_dir'];

@ob_start();
@session_start();
set_time_limit(0);
error_reporting(-1);
ini_set("max_execution_time", 0);
ini_set("memory_limit", "250M");
ini_set('display_errors', $settings['debug']);
ini_set('date.timezone', $settings['timezone']);


define('SCRIPT_VERSION', 'Hash Script Generator v1.0.0');
define('LOCAL_HASH_FILE', __DIR__ . '/local_files.xml');
define('REMOTE_HASH_FILE', __DIR__ . '/remote_files.xml');

function generateHashFile($output_file, $is_remote_server) {
	global $settings;
	
	$currentTime = date("Y-m-d H:m:s");
	$fp = fopen($output_file, "w");
	if(!$fp) {
		die('Unable to create hash file, check directory permissions or path');
	}
	$timeStart = microtime(true);
	fwrite($fp, "<files>");
	$filesCount = buildFilesList($fp, $settings, $is_remote_server);
	fwrite($fp, "</files>" . PHP_EOL);
	$timeEnd = microtime(true);
	fwrite($fp, "</report>" . PHP_EOL);
	fclose($fp);
	$timeSpent = util()->friendlyTime(round($timeEnd - $timeStart));
	
	#/ writing xml header and stats
	$headers = "<?xml version = \"1.0\" encoding=\"UTF-8\" ?>
	<report>
		<stats>
			<domain>%s</domain>
			<time>%s</time>
			<timeZone>%s</timeZone>
			<timeSpent>%s</timeSpent>
			<totalFiles>%s</totalFiles>
			<generator>%s</generator>
			<filters>*.*</filters>
		</stats>
	";
	$headers = sprintf($headers, $_SERVER['SERVER_NAME'], $currentTime, $settings['timezone'], $timeSpent, $filesCount, SCRIPT_VERSION);
	prependStringToFile($headers, $output_file);
}

function prependStringToFile( $string, $fileName ) {
	$context = stream_context_create();
	$fp = fopen( $fileName, 'r', 1, $context );
	$tmpFile = md5( $string );
	file_put_contents( $tmpFile, $string );
	file_put_contents( $tmpFile, $fp, FILE_APPEND );
	fclose( $fp );
	unlink( $fileName );
	rename( $tmpFile, $fileName );
}



function buildFilesList( $fp, $settings, $is_remote_server ) {
	$xmlNode = "
	<file>
		<name>%s</name>
		<hash>%s</hash>
		<mtime>%s</mtime>
	</file>";
	$srcPath = $settings['sourceDir'];
	$srcPath = str_replace("\\","/", $srcPath);
	$count = 0;
	$handle = opendir( $srcPath );
	if (!$handle) {
		die("Unable to read source directory.");
	}
	
	if ( $is_remote_server )
		$settings['excludeDirs'] = $settings['compare']['remote_exclude_dirs'];
	else
		$settings['excludeDirs'] = $settings['compare']['local_exclude_dirs'];
	
	while (($item = readdir( $handle )) !== false) {
		
		if ( $item == '.' || $item == '..' ) {
			continue;
		}
		
		$srcPath = rtrim( $srcPath, '/\\' ) . '/';
		$source = $srcPath . $item;
		if ( is_dir( $source )) {
			if ( in_array($source, $settings['excludeDirs'] ) ) {
				continue;
			}
			$settings['sourceDir'] = $srcPath .$item;
			$count += buildFilesList( $fp, $settings, $is_remote_server );
		} elseif (is_file( $source )) {
			$source = str_replace("\\","/",$source);
			//$node = sprintf( $xmlNode, $source, md5_file( $source ), date('Y-m-d H:m:s',filemtime( $source )) );
			if ( $settings['compare']['algorithm'] == 'FILE_SIZE' ) {
				$node = sprintf($xmlNode, $source, filesize($source), date('Y-m-d H:m:s', filemtime($source)));
			}
			else if($settings['compare']['algorithm'] == 'FILE_TIME') {
				$node = sprintf($xmlNode, $source, filemtime($source), date('Y-m-d H:m:s', filemtime($source)));
			}
			else if($settings['compare']['algorithm'] == 'FILE_HASH') {
				$node = sprintf($xmlNode, $source, md5_file($source), date('Y-m-d H:m:s', filemtime($source)));
			}
			else {
				throw new Exception('Unknown algorithm: '. $settings['compare']['algorithm']);
			}
			fwrite( $fp, $node );
			$count++;
		}
	}
	closedir( $handle );
	return $count;
}

function formatResult($filesLoadingTime, $compareTime, $result) {
	
	//include("report.html");
}

function downloadHashFile( $url, $save_as ) {
	$fp = fopen($save_as, 'w+');
	$ch = curl_init(str_replace(" ", "%20", $url));
	curl_setopt($ch, CURLOPT_TIMEOUT, 50);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	return $save_as;
}



class App {
	
	private $errorMessage, $settings;
	
	public static function instance($settings) {
		static $instance;
		if(!$instance) {
			$instance = new App($settings);
		}
		
		return $instance;
	}
	
	public function __construct($settings) {
		$this->settings = $settings;
	}
	
	public function handleAuthPost() {
		//echo '<pre>' . print_r($this->settings,1) . print_r($_POST,1);
		if( util()->post('username') == $this->settings['auth']['username'] &&
			util()->post('password') == $this->settings['auth']['password'])
		{
			util()->setSession('access-allowed', true);
			util()->redirectTo('start.php');
		}
		$this->errorMessage = 'Invalid username or password';
		return false;
	}
	
	public function getErrorMessage() {
		return $this->errorMessage;
	}
	
	public function hasAuthSession() {
		return util()->hasSession('access-allowed');
	}
	
	public function handleLoginAction() {
	
	}
}

class Util {
	
	public static function instance() {
		static $instance;
		if ( !$instance )
			$instance = new Util();
		return $instance;
	}
	
	public function get( $key ) {
		if ( !isset($_GET[$key]) )
			return null;
		return $_GET[ $key ];
	}
	
	public function isPost() {
		return $_POST;
	}
	
	public function post($key ) {
		if ( !isset($_POST[$key]) ) {
			return null;
		}
		return $_POST[$key];
	}
	
	public function setSession( $key, $val ) {
		return $_SESSION[$key] = $val;
	}
	
	public function hasSession( $key ) {
		return array_key_exists($key, $_SESSION);
	}
	
	public function getSession( $key ) {
		if ( !$this->hasSession($key) )
			return null;
		return $_SESSION[$key];
	}
	
	public function redirectTo($page) {
		$this->reloadPage( $page );
	}
	
	public function reloadPage($page=null) {
		$page = !is_null($page) ? $page : $_SERVER['REQUEST_URI'];
		header('location: '.$page);
		exit;
	}
	
	public function friendlyTime($seconds) {
		$w = $seconds / 86400 / 7;
		$d = $seconds / 86400 % 7;
		$h = $seconds / 3600 % 24;
		$m = $seconds / 60 % 60;
		$s = $seconds % 60;
		$output = array();
		if($w >= 1) {
			$output[] = "{$w} " . ($w == 1 ? 'week' : 'weeks');
		}
		if($d >= 1) {
			$output[] = "{$d} " . ($d == 1 ? 'day' : 'days');
		}
		if($h >= 1) {
			$output[] = "{$h} " . ($h == 1 ? 'hour' : 'hours');
		}
		if($m >= 1) {
			$output[] = "{$m} " . ($m == 1 ? 'minute' : 'minutes');
		}
		if($s >= 1) {
			$output[] = "{$s} " . ($s == 1 ? 'second' : 'seconds');
		}
		else {
			$output[] = "less then a second";
		}
		
		return implode(', ', $output);
	}
	
}

/**
 * @return Util
 */
function util() {
	return Util::instance();
}

/**
 * @return App
 */
function app() {
	global $settings;
	return App::instance($settings);
}
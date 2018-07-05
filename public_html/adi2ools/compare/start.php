<?php
require_once("config.php");

$filesLoadingTime = -microtime(true);

// download remote file
downloadHashFile($settings['auth']['remote_url'].'?key='. $settings['auth']['remote_key'], REMOTE_HASH_FILE );
if ( !file_exists(REMOTE_HASH_FILE )) {
	die("Unable to download remote file.");
}


// generate local file
generateHashFile(LOCAL_HASH_FILE, false);
if ( !file_exists( LOCAL_HASH_FILE )) {
	die("New specified file <code>". LOCAL_HASH_FILE.'</code> does not exists.');
}

// load files
$remoteXml = simplexml_load_file(REMOTE_HASH_FILE );
$localXml = simplexml_load_file(LOCAL_HASH_FILE );
$filesLoadingTime += microtime(true);

#/ getting files list
$remoteFiles = $remoteXml->files->file;
$localFiles = $localXml->files->file;


$result = array(
	'changed' => array(),
	'missing' => array(),
	'new' => array()
);

$compareTime = -microtime(true);

#/ checking for changed or missing files
foreach($remoteFiles as $remoteFile ) {
	$oldFileFound = false;
	foreach($localFiles as $localFile ) {
		if ( trim($remoteFile->name) == trim($localFile->name) ) {
			$oldFileFound = true;
			if (strcmp($remoteFile->hash, $localFile->hash) !== 0) {
				$result['changed'][] = array(
					'name' => (string)$remoteFile->name,
					'oldTime' => (string)$remoteFile->mtime,
					'newTime' => (string)$localFile->mtime,
				);
			}
			break;
		}
	
	}
	
	if (!$oldFileFound) {
		$result['missing'][] = array(
			'name' => (string)$remoteFile->name,
			'oldTime' => (string)$remoteFile->modifiedTime,
			'newTime' => ''
		);
	}
}

#/ checking for new files
foreach($localFiles as $localFile ) {
	$fileFound = false;
	foreach($remoteFiles as $remoteFile ) {
		if ( trim($localFile->name) == trim($remoteFile->name)  ) {
			$fileFound = true;
			break;
		}
	}
	if (!$fileFound) {
		$result['new'][] = array(
			'name' => (string)$localFile->name,
			'oldTime' => '',
			'newTime' => (string)$localFile->modifiedTime
		);
	}
}

$compareTime += microtime(true);

#/ removing files
unlink(REMOTE_HASH_FILE);
unlink(LOCAL_HASH_FILE);

//formatResult($filesLoadingTime, $compareTime, $result);
include('result.php');
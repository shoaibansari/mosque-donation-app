<?php
set_time_limit(0);
ini_set( 'date.timezone', 'Asia/Karachi');
ini_set( 'display_errors', 'on');
error_reporting( -1 );

function createArchive( $sourceDir, $dstFile) {
	echo $cmd = "tar -zcvf $dstFile $sourceDir";
	$backupStatus = exec($cmd);
	echo "<br>";
	echo "*** Result: ". (($backupStatus) ? "Successful" : "Failed.") . " ***";
	echo "<br>";
}

function iterateProjects( $srcPath ) {
	global $xmlNode;
	$srcPath = $settings['sourceDir'];
	$srcPath = str_replace("\\","/", $srcPath);
	$count = 0;
	$handle = opendir( $srcPath );
	if (!$handle) {
		die("Unable to read source directory.");
	}
	while (($item = readdir( $handle )) !== false) {
		if ($item == '.' || $item == '..' || in_array($srcPath, $settings['ignoreDirs']) ) {
			continue;
		}
		$srcPath = rtrim( $srcPath, '/\\' ) . '/';
		$source = $srcPath . $item;
		if (is_dir( $source )) {
			$settings['sourceDir'] = $srcPath .$item;
			$count += buildFilesList( $fp, $settings );
		} elseif (is_file( $source )) {
			$source = str_replace("\\","/",$source);
			$node = sprintf( $xmlNode, $source, md5_file( $source ), date('Y-m-d H:m:s',filemtime( $source )) );
			fwrite( $fp, $node );
			$count++;
		}
	}
	closedir( $handle );
	return $count;
}

?><html>
<head>
	<style>
		body,html {
			font-family: Arial, Helvetica, sans-serif; 			
			font-size:13px; 	
		}
	</style>
</head>
<body>
<?php
	$sourceDir = dirname(__FILE__);
	$backupDir = dirname(__FILE__);
	if ( $backupDir != "" ) {
		$backupDir .= "/";
	} 
	$backupFile = $backupDir."backup-".date("Y-m-d").".tar.gz";
	if ( isset($_GET['backup']) && $_GET['backup'] ) {
		echo $cmd = "tar -zcvf $backupFile $sourceDir";
		$backupStatus = exec($cmd);
		echo "<br>";
		echo "*** Backup ". (($backupStatus) ? "Successful" : "Failed.") . "***";
	} else {
		echo "Backup version: 1.0<br>";
		echo "Source Directory: ".$sourceDir."<br>";
		echo "Destination Directory: ".$backupDir."<br>";
		echo "Destination File: ".$backupFile."<br>";
	}
?>

</body>
</html>
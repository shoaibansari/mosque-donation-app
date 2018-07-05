<?php
require_once("config.php");

if ( !util()->get('key') == $settings['auth']['remote_key'] ) {
	die('Invalid or expired session.');
}


generateHashFile( REMOTE_HASH_FILE, true );

$fileType = 'text/xml';
$fileName = basename(REMOTE_HASH_FILE );
$fileSize = filesize(REMOTE_HASH_FILE );

header( "Pragma: public" );
header( 'Expires: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
header( "Cache-Control: private", false );
header( "Content-Type: application/force-download", true ); //
header( "Content-Type: " . $fileType, false );
header( "Content-Type: application/download", false ); //
header( 'Content-Disposition: attachment; filename="' . $fileName . '"' );
header( "Content-Transfer-Encoding: binary" );
header( 'Content-Length: ' . $fileSize );
@set_time_limit( 900 );
//@ob_clean();
ob_end_clean();
echo file_get_contents(REMOTE_HASH_FILE );
@unlink(REMOTE_HASH_FILE );

//$timeFriendly = secondsToFriendlyName( $timeEnd - $timeStart );
//echo "Script executed successfully in " . $timeFriendly;


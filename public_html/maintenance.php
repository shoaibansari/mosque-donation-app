<?php
$allowAccess = true;

if ( isset($shutdown) && array_key_exists('down', $shutdown) && $shutdown['down']) {
	$heading = isset($shutdown['heading']) ? $shutdown[ 'heading' ] : 'Site is down for maintenance';
	$description = isset( $shutdown[ 'description' ] ) ? $shutdown[ 'description' ] : '';
	$emailTo = isset($shutdown['emailTo']) ? $shutdown[ 'emailTo' ] : '';
	$allowedIPs = isset( $shutdown[ 'allowedIPs' ] ) ? $shutdown[ 'allowedIPs' ] : '';
	$httpStatus = isset($shutdown['httpStatus']) ? $shutdown[ 'httpStatus' ] : 503;

	if ( !is_array($allowedIPs) ) {
		$allowedIPs = explode( ",", $allowedIPs );
	}

	if ( !in_array($_SERVER['REMOTE_ADDR'], $allowedIPs) ) {
		$allowAccess = false;
	}

	if ( !$allowAccess ) {

		if (!function_exists('http_response_code')) {
		    function http_response_code($newcode = NULL) {
		        static $code = 200;
		        if($newcode !== NULL) {
		            header('X-PHP-Response-Code: '.$newcode, true, $newcode);
		            if(!headers_sent())
		                $code = $newcode;
		        }
		        return $code;
		    }
		}

		http_response_code( $httpStatus );
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $heading ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style type="text/css">
            body { text-align: center; padding: 10%; font: 20px Helvetica, sans-serif; color: #333; }
            h1 { font-size: 50px; margin: 0; }
            article { display: block; text-align: left; max-width: 720px; margin: 0 auto; }
            a { color: #dc8100; text-decoration: none; }
            a:hover { color: #333; text-decoration: none; }
            @media only screen and (max-width : 480px) {
                h1 { font-size: 40px; }
            }
        </style>
    </head>
    <body>
        <article>
            <h1><?= $heading ?></h1>
            <p></p>
	        <p id="signature">&mdash; <a href="mailto:<?= $emailTo ?>">FSD Solutions</a></p>
        </article>
    </body>
</html>
<?php
		die();
	}
}

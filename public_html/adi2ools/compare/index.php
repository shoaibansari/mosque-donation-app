<?php
require_once("config.php");
if( app()->hasAuthSession() ) {
	util()->redirectTo('start.php');
}
else if ( util()->isPost() ) {
	app()->handleAuthPost();
}
else {
	include('login.php');
}



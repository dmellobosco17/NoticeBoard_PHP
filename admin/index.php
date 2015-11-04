<?php
session_start ();

global $NB;

$NB = "true";

if (! isset ( $_GET ['opt'] )) {
	$_GET ['opt'] = "dashboard";
}

// Is user logged in?
if (! isset ( $_SESSION ['user'] ) && @$_GET ['opt'] != 'authenticate') {
	$_GET ['opt'] = 'login';
} else {
	// If user is already logged in and trying to acces login page then redirect to dashboard
	if ($_GET ['opt'] == 'login') {
		$_GET ['opt'] = 'dashboard';
	}
}

// Is opt is specified?
if (! isset ( $_GET ['opt'] )) {
	$_GET ['opt'] = 'dashboard';
}

global $data, $db_con;

// load global parameters
include 'model/init_globals.php';

// load common view functions
include 'view/functions.php'; 

// Initialize database connection
include 'model/db_connection.php';

switch ($_GET ['opt']) {
	case 'dashboard' :
		include 'model/dashboard.php';
		include 'view/dashboard_view.php';
		break;
	case 'authenticate' :
		include 'model/authenticate.php';
		break;
	case 'logout' :
		include 'model/logout.php';
		include 'view/login_view.php';
		break;
	case 'new_notice' :
		include 'model/new_notice.php';
		include 'view/new_notice_view.php';
		break;
	case 'publish' :
		include 'model/publish.php';
		break;
	default :
		include 'view/login_view.php';
		break;
			
}

?>
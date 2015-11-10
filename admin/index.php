<?php
//TODO allow flow from index.php ONLY !!!

// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);

session_start ();

define("INDEX", true);


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
$data=array();

include 'model/API_KEYS.php';

// load global parameters
include 'model/init_globals.php';

// load common view functions
include 'view/functions.php'; 

// Initialize database connection
include 'model/db_connection.php';

//Set error handler
set_error_handler("handle_error");

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
	case 'live_feed' :
		include 'model/live_feed.php';
		break;
	case 'password' :
		include 'model/change_password.php';
		include 'view/change_password_view.php';
		break;
	case 'edit_user' :
		//Is user admin
		if($_SESSION['user_type'] != 'ADMIN'){
			alert("Only admin can access this page!!!");
			include 'model/dashboard.php';
			include 'view/dashboard_view.php';
			break;
		}
		include 'model/edit_user.php';
		include 'view/edit_user_view.php';
		break;
	case 'remove_user' :
		//Is user admin
		if($_SESSION['user_type'] != 'ADMIN'){
			alert("Only admin can access this page!!!");
			include 'model/dashboard.php';
			include 'view/dashboard_view.php';
			break;
		}
		include 'model/remove_user.php';
		break;
	case 'manage_users' :
		//Is user admin
		if($_SESSION['user_type'] != 'ADMIN'){
			alert("Only admin can access this page!!!");
			include 'model/dashboard.php';
			include 'view/dashboard_view.php';
			break;
		}
		include 'model/manage_users.php';
		include 'view/manage_users_view.php';
		break;
	case 'remove_channel' :
		//Is user admin
		if($_SESSION['user_type'] != 'ADMIN'){
			alert("Only admin can access this page!!!");
			include 'model/dashboard.php';
			include 'view/dashboard_view.php';
			break;
		}
		include 'model/remove_channel.php';
		break;
	case 'manage_channels' :
		//Is user admin
		if($_SESSION['user_type'] != 'ADMIN'){
			alert("Only admin can access this page!!!");
			include 'model/dashboard.php';
			include 'view/dashboard_view.php';
			break;
		}
		include 'model/manage_channels.php';
		include 'view/manage_channels_view.php';
		break;
	case 'add_user' :
		//Is user admin
		if($_SESSION['user_type'] != 'ADMIN'){
			alert("Only admin can access this page!!!");
			include 'model/dashboard.php';
			include 'view/dashboard_view.php';
			break;
		}
		include 'model/add_user.php';
		include 'view/add_user_view.php';
		
		break;
	case 'add_channel' :
		//Is user admin
		if($_SESSION['user_type'] != 'ADMIN'){
			alert("Only admin can access this page!!!");
			include 'model/dashboard.php';
			include 'view/dashboard_view.php';
			break;
		}
		include 'model/add_channel.php';
		include 'view/add_channel_view.php';
		
		break;
	default :
		if(isset($_SESSION['user'])){
			include 'model/dashboard.php';
			include 'view/dashboard_view.php';
		}else{
			include 'view/login_view.php';
		}
		break;
			
}

?>
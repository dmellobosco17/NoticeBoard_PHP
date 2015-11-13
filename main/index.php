<?php
header('Content-Type: text/html; charset=utf-8');
global $data;

define("INDEX", true);

$data = array();
$data['log'] = "";

include 'model/db_connection.php';

include 'model/functions.php';

switch($_GET['opt']){
	case 'register_token' :
		include 'model/register_token.php'; 
		break;
	case 'sync_db' :
		include 'model/sync_db.php';
		break;
}

echo json_encode($data);
?>
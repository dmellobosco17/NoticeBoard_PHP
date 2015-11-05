<?php

global $NB,$data;

$NB = true;

$data = array();

include 'model/db_connection.php';

include 'model/functions.php';

switch($_GET['opt']){
	case 'register_token' :
		include 'model/register_token.php'; 
		break;
}

echo json_encode($data);
?>
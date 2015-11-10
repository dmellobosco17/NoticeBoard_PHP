<?php
global $NB;

$NB = true;

include '../model/db_connection.php';
include 'functions.php';

$IMEI = "353326065856538-";

$result = fetchData('tokens', array('token','channels'), false, 'imei', $IMEI);

if(!is_array($result))
	echo "No result";
else
	print_r($result);

?>
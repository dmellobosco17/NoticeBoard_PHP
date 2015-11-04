<?php

$stmt = $db_con->prepare ( 'SELECT * FROM `users` WHERE `username` = :username LIMIT 1' );
$stmt->execute ( array (
		'username' => $_SESSION ['user']
) );

$row = $stmt->fetch ();

$json = $row['channel'];

$ch = json_decode($json);

$channels = array();

foreach ($ch as $c){
	$channels[$c]['id'] = $c;
	$result = fetchData('channels', array('name'), false, 'id', $c);
	$channels[$c]['name'] = $result['name'];
}

$data['channels'] = $channels;
?>
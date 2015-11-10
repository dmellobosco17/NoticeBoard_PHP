<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}


// Information submitted?
if (@$_GET ['act'] == 'do' && isset ( $_POST['id'] )) {
	if($_SESSION['user_type'] != 'ADMIN'){
		die("Attempt to hack !!!");
	}
	
	$pass = $_POST ['pass1'];
	
	$sql = "UPDATE `users` SET `username` = :name," . ($pass != '' ? '`password` = :pass,' : '') . " `type` = :type, `channel` = :channel WHERE `id` = :id";
	$params = array (
			'name' => $_POST ['username'],
			'type' => $_POST ['type'],
			'channel' => str_replace ( '"', '', json_encode ( $_POST ['channel'] ) ),
			'id' => $_POST ['id'] 
	);
	
	if ($pass != '')
		$params ['pass'] = $pass;
	
	$stmt = $db_con->prepare ( $sql );
	if ($stmt->execute ( $params )) {
		echo "<script>alert('User edited successfuly');</script>";
	}else{
		echo "<script>alert('Failure');</script>";
	}
}

if (isset ( $_GET ['id'] ))
	$id = $_GET ['id'];
else
	$id = $_POST ['id'];

$user = fetchData ( 'users', array (
		'id',
		'username',
		'type',
		'channel' 
), false, 'id', $id );

$data ['user'] = $user;

$channels = fetchData ( 'channels', null, true );

$data ['channels'] = $channels;

?>
<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

if ($_SESSION ['user_type'] != 'ADMIN') {
	die ( "Attempt to hack!!!" );
}

$id = $_POST ['id'];
$params = array (
		'id' => $id 
);

// Remove entries from users table
$sql = "SELECT `id`,`channel` FROM `users` WHERE `channel` LIKE ?";
$stmt = $db_con->prepare ( $sql );
$stmt->execute ( array("%$id%") );
$users = $stmt->fetchAll ();

foreach ( $users as $u ) {
	$channels = json_decode ( $u['channel']);
	if (($key = array_search ( $id, $channels )) !== false) {
		unset ( $channels [$key] );
		$channels = array_values($channels);
		$sql = "UPDATE `users` SET `channel`= ? WHERE `id` = $u[id]";
		$stmt = $db_con->prepare ( $sql );
		$stmt->execute ( array(json_encode($channels)) );
	}
}

// Remove entries from tokens table
$sql = "SELECT `id`,`channels` FROM `tokens` WHERE `channels` LIKE ?";
$stmt = $db_con->prepare ( $sql );
$stmt->execute ( array("%$id%") );
$users = $stmt->fetchAll ();

foreach ( $users as $u ) {
	$channels = json_decode ( $u['channels']);
	if (($key = array_search ( $id, $channels )) !== false) {
		unset ( $channels [$key] );
		$channels = array_values($channels);
		$sql = "UPDATE `tokens` SET `channels`= ? WHERE `id` = $u[id]";
		$stmt = $db_con->prepare ( $sql );
		$stmt->execute ( array(json_encode($channels)) );
	}
}

$sql = "DELETE FROM `channels` WHERE `id` = :id";
$stmt = $db_con->prepare ( $sql );
if ($stmt->execute ( $params )) {
	$sql = "DROP TABLE `channel_$_POST[id]`";
	$stmt = $db_con->prepare ( $sql );
	
	if ($stmt->execute ( $params )) {
		echo "success";
	}
} else {
	echo "Failure";
}

?>
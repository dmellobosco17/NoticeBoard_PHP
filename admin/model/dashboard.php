<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

global $data;

$stmt = $db_con->prepare ( 'SELECT * FROM `users` WHERE `username` = :username LIMIT 1' );
$stmt->execute ( array (
		'username' => $_SESSION ['user']
) );

$row = $stmt->fetch ();
$json = $row['channel'];
$ch = json_decode($json);

$sql="SELECT `user`, `subject`, `content`, `time`, `expiry`, `channel`, `channel_name`, `priority` FROM `notices` WHERE `channel` IN (".implode(',', $ch).") ORDER BY `id` DESC";

$stmt = $db_con->prepare ($sql);
$stmt->execute(null);

$notices = $stmt->fetchAll();

$data['notices'] = $notices;
?>
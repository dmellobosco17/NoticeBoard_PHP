<?php
if (! defined ( 'INDEX' )) {
	die ( "Attempt to hack !!!" );
}

$subject = $_POST ['subject'];
$content = $_POST ['content'];
$DOE = $_POST ['date'];
$priority = $_POST ['priority'];
$channel = $_POST ['channel'];

$content = str_replace ( "\n", "<br/>", $_POST ['content'] );
$channel_name = "";

if ($channel == 0) {
	$channel_name = "All";
} else {
	$ch = fetchData ( 'channels', 'name', false, 'id', $channel );
	$channel_name = $ch ['name'];
}
try {
	$stmt = $db_con->prepare ( 'INSERT INTO `notices` (`user`, `subject`, `content`, `expiry`, `channel`, `channel_name`, `priority`) VALUES (:user,:subject,:content,:DOE,:channel,:channel_name,:priority)' );
	
	$stmt->execute ( array (
			'user' => $_SESSION ['user'],
			'subject' => $subject,
			'content' => $content,
			'DOE' => $DOE,
			'channel' => $channel,
			'channel_name' => $channel_name,
			'priority' => $priority 
	) );
	
	//echo "success";
} catch ( PDOException $e ) {
	echo $e->getMessage ();
}

$notice_id = $db_con->lastInsertId ();

$notice = array (
		'subject' => $subject,
		'content' => $content,
		'priority' => $priority,
		'channel' => $channel,
		'channel_name' => $channel_name,
		'DOE' => $DOE,
		'id' => $notice_id 
);

$i="";
if($channel == 0)
	$i = fetchData ( 'tokens', 'token', true );
else
	$i = fetchData ( 'channel_' . $channel, 'token', true );

$ids = array ();
foreach ( $i as $j ) {
	array_push ( $ids, $j ['token'] );
}
sendGoogleCloudMessage ( $notice, $ids );
?>
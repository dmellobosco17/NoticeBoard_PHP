<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

global $data;

$channels = fetchData ( 'channels', null, true );

$channels2 = array ();

foreach ( $channels as $ch ) {
	$notices = fetchData ( 'notices', array (
			'channel' 
	), true, 'channel', $ch ['id'] );
	$ch ['published_notices'] = count ( $notices );
	
	$stmt = $db_con->prepare ( "SELECT COUNT(id) AS subs FROM channel_" . $ch ['id'] );
	$stmt->execute ( array () );
	
	$result = $stmt->fetch ();
	$ch ['subs'] = $result ['subs'];
	
	array_push ( $channels2, $ch );
}
$data ['channels'] = $channels2;
?>
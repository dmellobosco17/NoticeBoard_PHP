<?php
if (! defined ( 'INDEX' )) {
	die ( "Attempt to hack !!!" );
}

$c = urldecode ( $_POST ['channels'] );
$IMEI = urldecode ( $_POST ['IMEI'] );
$token = urldecode ( $_POST ['token'] );

// Check for token registration
$result = fetchData ( 'tokens', array (
		'token'
), false, 'imei', $IMEI );
$params = array (
		'token' => $token,
		'imei' => $IMEI 
);
if (is_array ( $result )) {
	if ($result ['token'] == $token) {
		$data ['result'] = 'success';
	} else {
		// Update tokens table
		$sql = "UPDATE `tokens` SET `token`=:token WHERE `imei`=:imei";
		
		try {
			$stmt = $db_con->prepare ( $sql );
			$stmt->execute ( $params );
			$data ['result'] = 'success';
		} catch ( PDOException $e ) {
			$data ['result'] = 'Failed to update tokens table';
		}
		// Update channels table
		$ch = fetchData('channels', 'id', true);
		
		foreach ( $ch as $channel ) {
			$sql2 = "UPDATE `channel_" . $channel['id'] . "` SET `token`=:token WHERE `imei`=:imei";
			try {
				$stmt = $db_con->prepare ( $sql2 );
				$stmt->execute ( $params );
				$data ['result'] = 'success';
			} catch ( PDOException $e ) {
				$data ['result'] = 'Failed to update channel ' . $channel;
			}
		}
	}
}

// Now fetch notices
$channels = json_decode ( $c );

// Add new channels
foreach ( $channels as $ch ) {
	$sql = "SELECT * FROM `channel_$ch` WHERE `imei` = :imei";
	$stmt = $db_con->prepare ( $sql );
	$stmt->execute ( array (
			'imei' => $IMEI 
	) );
	if ($stmt->rowCount () < 1) {
		$sql = "INSERT INTO `channel_$ch` (`token`, `imei`) VALUES (:token, :imei)";
		$stmt = $db_con->prepare ( $sql );
		$data['log'].=$stmt->execute ( $params );
	}
}

// Remove user from channels
$db_channels = fetchData ( 'channels', 'id', true );
foreach ( $db_channels as $ch ) {
	if (! in_array ( $ch['id'], $channels )) {
		$sql = "DELETE FROM `channel_$ch[id]` WHERE `imei` = :imei";
		$stmt = $db_con->prepare ( $sql );
		$stmt->execute ( array('imei' => $IMEI) );
	}
}

array_push($channels, 0);
$sql = "SELECT * FROM `notices` WHERE `channel` IN (" . implode ( ',', $channels ) . ")";
$stmt = $db_con->prepare ( $sql );
$stmt->execute ();

$notes = $stmt->fetchAll ();

$notices = array ();

foreach ( $notes as $note ) {
	array_push ( $notices, array (
			'id' => $note ['id'],
			'subject' => $note ['subject'],
			'content' => $note ['content'],
			'priority' => $note ['priority'],
			'channel' => $note ['channel'],
			'channel_name' => $note ['channel_name'],
			'expiry' => $note ['expiry'] 
	) );
}

$data ['notices'] = $notices;

// Get all channels
$chans = fetchData ( 'channels', null, true );
$channels = array ();
foreach ( $chans as $ch ) {
	array_push ( $channels, array (
			'id' => $ch ['id'],
			'name' => $ch ['name'],
			'description' => $ch ['description'] 
	) );
}

$data ['channels'] = $channels;

?>

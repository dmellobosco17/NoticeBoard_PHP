<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

// Information submitted?
if (@$_GET ['act'] == 'do') {
	$sql = "INSERT INTO `channels` (`name`, `description`) VALUES (:name,:desc)";
	$params = array (
			'name' => $_POST ['name'],
			'desc' => $_POST ['desc'] 
	);
	
	$stmt = $db_con->prepare ( $sql );
	if ($stmt->execute ( $params )) {
		$id = $db_con->lastInsertId ();
		$sql = "CREATE TABLE `channel_$id` ( `id` INT NOT NULL AUTO_INCREMENT , `token` VARCHAR(200) NOT NULL , `imei` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`imei`)) ENGINE = InnoDB;";
		
		$stmt = $db_con->prepare ( $sql );
		if ($stmt->execute ( $params )) {
			alert ( "Channel created successfully." );
		} else {
			alert ( "Table creation failed!!!" );
		}
	} else {
		alert ( "Channel creation failed!!!" );
	}
}
$channels = fetchData ( 'channels', null, true );

$data ['channels'] = $channels;

?>
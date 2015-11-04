<?php
global $data;

$sql="SELECT `user`, `subject`, `content`, `time`, `expiry`, `channel`, `priority` FROM `notices` WHERE `channel`=:channel ORDER BY `id` DESC LIMIT 20";

$stmt = $db_con->prepare ($sql);
$stmt->execute ( array ('channel'=>'1') );

$notices = $stmt->fetchAll();


$channel = fetchData('channels', array('name'), false);

$i=0;
foreach ($notices as $note){
	$notices[$i++]['channel'] = $channel['name'];
}

$data['notices'] = $notices;
?>
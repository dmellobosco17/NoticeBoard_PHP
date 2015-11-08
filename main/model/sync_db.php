<?php
$c = urldecode($_POST['channels']);

$channels = json_decode($c);

$sql = "SELECT * FROM `notices` WHERE `channel` IN (".implode(',', $channels).")";
$stmt = $db_con->prepare ($sql);
$stmt->execute ();

$notes = $stmt->fetchAll();

$notices = array();

foreach($notes as $note){
	array_push($notices,array(
	'id' => $note['id'],
	'subject' => $note['subject'],
	'content' => $note['content'],
	'priority' => $note['priority'],
	'channel' => $note['channel'],
	'expiry' => $note['expiry']
));
}

$data['notices'] = $notices;
?>

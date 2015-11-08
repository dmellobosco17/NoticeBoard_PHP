<?php
$subject = $_POST['subject'];
$content = $_POST['content'];
$DOE = $_POST['date'];
$priority = $_POST['priority'];
$channel = $_POST['channel'];

try{
$stmt = $db_con->prepare ( 'INSERT INTO `notices` (`user`, `subject`, `content`, `expiry`, `channel`, `priority`) VALUES (:user,:subject,:content,:DOE,:channel,:priority)' );
$stmt->execute ( array (
		'user' => $_SESSION['user'],
		'subject' => $subject,
		'content' => $content,
		'DOE' => $DOE,
		'channel' => $channel,
		'priority' => $priority
) );

echo "success";
}catch(PDOException $e){
	echo $e->getMessage();
}

$notice_id = $db_con->lastInsertId() ;

$notice = array(
	'subject' => $subject,
	'content' => $content,
	'priority' => $priority,
	'channel' => $channel,
	'DOE' => $DOE,
	'id' => $notice_id
);


$i = fetchData('tokens', 'token', true);

$ids = array();
foreach ($i as $j){
	array_push($ids, $j['token']);
}
sendGoogleCloudMessage($notice, $ids);
?>
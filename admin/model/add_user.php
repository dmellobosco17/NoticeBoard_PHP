<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

//Information submitted?
if(@$_GET['act'] == 'do')
{
	$sql = "INSERT INTO `users` (`username`,`password`,`type`,`channel`) VALUES (:name,:pass,:type,:channel)";
	$params = array(
		'name' => $_POST['username'],
		'pass' => $_POST['pass1'],
		'type' => $_POST['type'],
		'channel' => '['.$_POST['channel'].']'
	);
	
	$stmt = $db_con->prepare ($sql);
	$stmt->execute ($params);
	
	echo "<script>alert('New user created successfuly');</script>";
	
}
$channels = fetchData('channels', null, true);

$data['channels'] = $channels;

?>
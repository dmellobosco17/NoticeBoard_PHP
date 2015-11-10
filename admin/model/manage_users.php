<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

global $data;

$users = fetchData('users', null, true);

$users2=array();

foreach ($users as $u){
	$notices = fetchData('notices', array('user'), true, 'user', $u['username']);
	$u['channel'] = count(json_decode($u['channel']));
	$u['published_notices'] = count($notices);
	array_push($users2, $u);
}
$data['users'] = $users2;
?>
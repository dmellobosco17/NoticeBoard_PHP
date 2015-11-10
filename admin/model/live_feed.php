<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

//Live feed fetch similar entries present in database

switch($_POST['procedure_code']){
	case 'new_user_name' :
		$table = 'users';
		$column = 'username';
		break;
	case 'new_channel_name' :
		$table = 'channels';
		$column = 'name';
		break;
}
$seed = $_POST ['seed'];
$match = $_POST['match'];

global $db_con;

$params = array(
	'seed' => $seed
);

$sql = "";

if($match == 'exact')
	$sql = "SELECT `$column` FROM `$table` WHERE `$column` = :seed";
else
	$sql = "SELECT :column FROM :table WHERE :column LIKE %:seed%";

$stmt = $db_con->prepare ( $sql );
$stmt->execute ( $params );

echo json_encode($stmt->fetchAll());
?>
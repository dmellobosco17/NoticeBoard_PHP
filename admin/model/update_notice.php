<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

$DOE = $_POST['DOE'];
$id = $_POST['id'];

$sql = "UPDATE `notices` SET `expiry` = :DOE WHERE `id` = :id";
$params = array(
	'DOE' => $DOE,
	'id' => $id
);
$stmt = $db_con->prepare ( $sql );
if($stmt->execute ( $params )){
	echo "success";
}else{
	echo "failure";
}

?>
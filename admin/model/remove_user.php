<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

if($_SESSION['user_type'] != 'ADMIN'){
	die("Attempt to hack!!!");
}

	$sql = "DELETE FROM `users` WHERE `id` = :id";
	$params = array (
			'id' => $_POST ['id']
	);
	
	$stmt = $db_con->prepare ( $sql );
	if ($stmt->execute ( $params )) {
		echo "success";
	}else{
		echo "<script>alert('Failure');</script>";
	}

?>
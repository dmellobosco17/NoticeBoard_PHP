<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

if(@$_GET['act'] == 'do'){
	$pass = $_POST ['pass1'];
	
	if($pass == ''){
		alert("Password connot be empty");
		return;
	}
	
	$sql = "UPDATE `users` SET `password` = :pass WHERE `username` = :user";
	$params = array (
			'user' => $_SESSION ['user'],
			'pass' => $pass
	);
	
	$stmt = $db_con->prepare ( $sql );
	if ($stmt->execute ( $params )) {
		echo "<script>alert('Password updated successfuly');</script>";
	}else{
		echo "<script>alert('Failure');</script>";
	}
}
?>
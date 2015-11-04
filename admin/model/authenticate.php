<?php
global $db_con;

$error = "";

if (isset ( $_SESSION ['user'] )) {
	$error .= "User is already logged in!!!\n";
	die ( $error );
}

if (! isset ( $_POST ['username'] )) {
	$error .= "Please provide username and password.\n";
	die ( $error );
}

$stmt = $db_con->prepare ( 'SELECT * FROM `users` WHERE `username` = :username LIMIT 1' );
$stmt->execute ( array (
		'username' => $_POST ['username'] 
) );

$row = $stmt->fetch ();

if ($_POST ['password'] == $row ['password']) {
	$_SESSION ['user'] = $_POST ['username'];
	echo 'success';
} else {
	echo "Invalid username and/or password.";
}
?>
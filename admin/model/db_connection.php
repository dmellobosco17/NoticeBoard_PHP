<?php
if (! isset ( $NB )) {
	die ( "Attempt to hack!!!" );
}

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "NoticeBoard";

global $db_con;

try {
	$db_con = new PDO ( 'mysql:host=localhost;dbname=NoticeBoard;charset=utf8', $db_user, $db_pass );
	$db_con->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch ( PDOException $e ) {
	echo 'ERROR: ' . $e->getMessage ();
}
?>
<?php

function fetchData($table,$cols,$array=false,$key=null,$value=null){
	global $db_con;
	$sql="";

	if(is_array($cols))
		$sql.="SELECT `".implode('`,`', $cols)."` from `$table`";
	else
		$sql.="SELECT * FROM `$table`";

	$params;

	if($key != null){
		$sql.=" WHERE `$key` = :value";
		$params = array ('value' => $value);
	}else{
		$params = array();
	}

	$stmt = $db_con->prepare ($sql);
	$stmt->execute ($params);

	if($array)
		return $stmt->fetchAll();
	else
		return $stmt->fetch();
}


?>
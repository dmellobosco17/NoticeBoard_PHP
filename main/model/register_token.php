<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

$token = urldecode($_POST['token']);
$IMEI = urldecode($_POST['IMEI']);

$result = fetchData('tokens', array('token','channels'), false, 'imei', $IMEI);
$params = array ('token' => $token, 'imei' => $IMEI);
if(is_array($result)){
	if($result['token'] == $token){
			$data['result'] = 'success';
			return;
		}
	//Update tokens table
	$sql="UPDATE `tokens` SET `token`=:token WHERE `imei`=:imei";
	
	try{
	$stmt = $db_con->prepare ($sql);
	$stmt -> execute ($params);
	$data['result'] = 'success';
	}catch(PDOException $e){
		$data['result'] = 'Failed to update tokens table';
	}
	//Update channels table
	$json = $result['channels'];
	$ch = json_decode($json);
	
	foreach ($ch as $channel){
		$sql2="UPDATE `channel_".$channel."` SET `token`=:token WHERE `imei`=:imei";
		try{
			$stmt = $db_con->prepare ($sql2);
			$stmt -> execute ($params);
			$data['result'] = 'success';
		}catch(PDOException $e){
			$data['result'] = 'Failed to update channel '.$channel;
		}
	}
}
else{
	$sql="INSERT INTO `tokens` (`token`,`imei`) VALUES (:token,:imei)";
	try{
$stmt = $db_con->prepare ($sql);
$stmt -> execute ($params);
$data['result'] = 'success';
}catch(PDOException $e){
	$data['result'] = 'Failed';
}
}




?>
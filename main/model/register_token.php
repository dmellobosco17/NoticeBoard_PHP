<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

$token = urldecode($_POST['token']);
$IMEI = urldecode($_POST['IMEI']);
$DEVICE = urldecode($_POST['DEVICE']);

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
	$ch = fetchData('channels','id',true);
	
	foreach ($ch as $channel){
		$sql2="UPDATE `channel_$channel[id]` SET `token`=:token WHERE `imei`=:imei";
		try{
			$stmt = $db_con->prepare ($sql2);
			$stmt -> execute ($params);
			$data['result'] = 'success';
		}catch(PDOException $e){
			$data['result'] = 'Failed to update channel '.$channel;
		}
	}
	$data['channels'] = $result['channels'];
}
else{
	$sql="INSERT INTO `tokens` (`token`,`imei`,`device`) VALUES (:token,:imei,:device)";
	try{
	$params['device'] = $DEVICE;
$stmt = $db_con->prepare ($sql);
$stmt -> execute (array ('token' => $token, 'imei' => $IMEI, 'device' => $DEVICE));
$data['result'] = 'success';
}catch(PDOException $e){
	$data['result'] = 'Failed';
}
}




?>
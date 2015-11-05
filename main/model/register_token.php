<?php
$token = urldecode($_POST['token']);
$IMEI = urldecode($_POST['IMEI']);

$result = fetchData('tokens', 'token', true, 'imei', $IMEI);
if(count($result) >= 1){
	foreach ($result as $r){
		if($r['token'] == $token){
			$data['result'] = 'success';
			return;
		}
	}
	$sql="UPDATE `tokens` SET `token`=:token WHERE `imei`=:imei";
}
else{
	$sql="INSERT INTO `tokens` (`token`,`imei`) VALUES (:token,:imei)";
}
$params = array ('token' => $token, 'imei' => $IMEI);

try{
$stmt = $db_con->prepare ($sql);
$stmt -> execute ($params);
$data['result'] = 'success';
}catch(PDOException $e){
	$data['result'] = 'Failed';
}


?>
<?php
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}

// Information submitted?
if (@$_POST ['act'] == 'do') {
	$params = array (
			'name' => $_POST ['name'],
			'desc' => $_POST ['desc'],
			'id' => $_POST['id']
	);
	$sql="";
	$image_name = save_image();
	if($data['log']['image'] == ""){
		$sql = "UPDATE `channels` SET `name` = :name , `description` = :desc , `image` = :image WHERE `id` = :id";
		$params['image'] = $image_name;
	}else{
		$sql = "UPDATE `channels` SET `name` = :name , `description` = :desc WHERE `id` = :id";
	}
	
	$stmt = $db_con->prepare ( $sql );
	if ($stmt->execute ( $params )) 
			alert ( "Channel edited successfully.");
		else {
		alert ( "failed!!!" );
	}
	
	//alert($data['log']);
}

if (isset ( $_GET ['id'] ))
	$id = $_GET ['id'];
else
	$id = $_POST ['id'];

$channel = fetchData ( 'channels', null, false, 'id', $id );

$data ['channel'] = $channel;

?>
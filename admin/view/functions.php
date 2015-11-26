<?php
if (! defined ( 'INDEX' )) {
	die ( "Attempt to hack !!!" );
}
?>
<?php

function common_view_imports() {
	// W3.CSS
	echo '<link rel="stylesheet" href="view/css/w3.css">';
	echo '<link rel="stylesheet" href="view/css/style.css">';
	echo '<script type="text/javascript" src="view/js/jquery-2.1.4.min.js"></script>';
	echo '<script type="text/javascript" src="view/js/script.js"></script>';
}
function side_navigation_panel($active = 'NULL') {
	$item = array ();
	
	$item ['Home'] = 'index.php';
	$item ['New Notice'] = 'index.php?opt=new_notice';
	// $item ['Search'] = 'index.php?opt=search';
	$item ['Advanced Options'] = array (
			'Manage Users' => 'index.php?opt=manage_users',
			'Manage Channels' => 'index.php?opt=manage_channels',
			'Change Password' => 'index.php?opt=password',
			'Logs' => 'index.php?opt=logs' 
	);
	
	$item ['Log Out'] = 'index.php?opt=logout';
	
	echo "<div class='w3-sidenav w3-teal w3-card-8' style='width:300px'>
		  <header class='w3-container w3-green' style='width: 300px;margin: -1px -30px 0px -16px;'>
		  <img src='../channel_imgs/cover.jpg' style='width: 300px;'/>
		  <h2 style='position: absolute;top: 113px;padding-left: 15px; background: rgba(0, 0, 0, 0.3); width: 100%;'>".strtoupper($_SESSION[user])."</h2>
		  </header>
		  <header class='w3-container w3-teal'>
		  <h5>Menu</h5>
		  
		  </header>";
	
	echo "<div id='cssmenu' style='width:100%'>" . arrayToMenu ( $item, $active ) . "</div>";
	
	echo "</div>";
}
function arrayToMenu($arr, $active) {
	$html = "<ul>";
	foreach ( $arr as $k => $v ) {
		if (is_array ( $v )) {
			$html .= "<li class='has-sub " . (array_key_exists ( $active, $v ) ? "active" : "") . "'><a href='#'>$k</a>";
			$html .= arrayToMenu ( $v, $active );
			$html .= "</li>";
		} else {
			$html .= "<li><a  class='" . ($k == $active ? "active" : "") . "' href='$v'>$k</a></li>";
		}
	}
	$html .= "</ul>";
	
	return $html;
}

/**
 *
 * @param string $table
 *        	Table name
 * @param
 *        	string array $cols columns to select
 * @param string $key
 *        	conditional key column
 * @param string $value
 *        	key value to be compare
 * @param boolean $array
 *        	true if result has multiple rows else false
 */
function fetchData($table, $cols, $array = false, $key = null, $value = null) {
	global $db_con;
	$sql = "";
	
	if (is_array ( $cols ))
		$sql .= "SELECT `" . implode ( '`,`', $cols ) . "` from `$table`";
	else
		$sql .= "SELECT * FROM `$table`";
	
	$params;
	
	if ($key != null) {
		$sql .= " WHERE `$key` = :value";
		$params = array (
				'value' => $value 
		);
	} else {
		$params = array ();
	}
	
	$stmt = $db_con->prepare ( $sql );
	$stmt->execute ( $params );
	
	if ($array)
		return $stmt->fetchAll ();
	else
		return $stmt->fetch ();
}
function alert($msg) {
	echo "<script type='text/javascript'>alert('" . $msg . "');</script>";
}
function sendGoogleCloudMessage($data, $ids) {
	global $apiKey;
	
	// ------------------------------
	// Define URL to GCM endpoint
	// ------------------------------
	
	$url = 'https://android.googleapis.com/gcm/send';
	
	// ------------------------------
	// Set GCM post variables
	// (Device IDs and push payload)
	// ------------------------------
	
	$post = array (
			'registration_ids' => $ids,
			'data' => $data 
	);
	
	// ------------------------------
	// Set CURL request headers
	// (Authentication and type)
	// ------------------------------
	
	$headers = array (
			'Authorization: key=' . $apiKey,
			'Content-Type: application/json' 
	);
	
	// ------------------------------
	// Initialize curl handle
	// ------------------------------
	
	$ch = curl_init ();
	
	// ------------------------------
	// Set URL to GCM endpoint
	// ------------------------------
	
	curl_setopt ( $ch, CURLOPT_URL, $url );
	
	// ------------------------------
	// Set request method to POST
	// ------------------------------
	
	curl_setopt ( $ch, CURLOPT_POST, true );
	
	// ------------------------------
	// Set our custom headers
	// ------------------------------
	
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	
	// ------------------------------
	// Get the response back as
	// string instead of printing it
	// ------------------------------
	
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	
	// ------------------------------
	// Set post data as JSON
	// ------------------------------
	
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode ( $post ) );
	
	// ------------------------------
	// Actually send the push!
	// ------------------------------
	
	$result = curl_exec ( $ch );
	
	// ------------------------------
	// Error? Display it!
	// ------------------------------
	
	if (curl_errno ( $ch )) {
		echo 'GCM error: ' . curl_error ( $ch );
	}
	
	// ------------------------------
	// Close curl handle
	// ------------------------------
	
	curl_close ( $ch );
	
	// ------------------------------
	// Debug GCM response
	// ------------------------------
	
	$result = json_decode($result,true);
	echo "Notice sent to ".$result['success']." people.";
}
function handle_error($errno, $errstr) {
	if (@$_GET ['debug'] == 'died')
		echo "<b>Error:</b> [$errno] $errstr<br>";
}

function save_image() {
	global $data;
	$data['log']['image']="";
	$target_dir = "../channel_imgs/";
	$imageFileType = pathinfo ( $_FILES ["image"] ["name"], PATHINFO_EXTENSION );
	$imageName = basename ( "channel_" . $_POST ['id'] . "." . $imageFileType );
	$target_file = $target_dir . $imageName;
	$uploadOk = 1;
	// Check if image file is a actual image or fake image
	if (isset ( $_FILES ["image"] )) {
		$check = getimagesize ( $_FILES ["image"] ["tmp_name"] );
		if ($check !== false) {
			$uploadOk = 1;
		} else {
			$data['log']['image'].= " File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check file size
	if ($_FILES ["image"] ["size"] > 150000) {
		$data['log']['image'] .= " Image should be less than 150KB.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
		$data['log']['image'] .= " Only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$data['log']['image'] .= " Your file was not uploaded.";
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file ( $_FILES ["image"] ["tmp_name"], $target_file )) {
		} else {
			$data['log']['image'] .= " There was an error uploading your file.";
		}
	}
	
	return $imageName;
}

function Log_d($tag,$msg){
global $data;
if(!isset($data['log'][$tag]))
	$data['log'][$tag] = "";

$data['log'][$tag].=$img;
}
?>
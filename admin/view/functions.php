<?php

function common_view_imports() {
	// W3.CSS
	echo '<link rel="stylesheet" href="view/css/w3.css">';
	echo '<link rel="stylesheet" href="view/css/style.css">';
	echo '<script type="text/javascript" src="view/js/jquery-2.1.4.min.js"></script>';
	echo '<script type="text/javascript" src="view/js/script.js"></script>';
}

function side_navigation_panel($active='NULL'){
	$item = array();
	
	$item['Home'] = 'index.php';
	$item['New Notice'] = 'index.php?opt=new_notice';
	$item['Search'] = 'index.php?opt=search';
	$item['Advanced Options'] = array(
		'Manage Users' => 'index.php?opt=manage_users',
		'Change Password' => 'index.php?opt=password',
		'Logs' => 'index.php?opt=logs',
	);
	
	$item['Log Out'] = 'index.php?opt=logout';
	
	echo "<div class='w3-sidenav w3-teal w3-card-8' style='width:19%'>
		  <header class='w3-container w3-green'>
		  <h5>$_SESSION[user]</h5>
		  </header>
		  <header class='w3-container w3-teal'>
		  <h5>Menu</h5>
		  
		  </header>";
	
	echo "<div id='cssmenu' style='width:100%'>".arrayToMenu($item,$active)."</div>";
	
	echo "</div>";
}

function arrayToMenu($arr,$active){
	$html = "<ul>";
	foreach($arr as $k => $v){
		if(is_array($v)){
			$html.="<li class='has-sub ".(array_key_exists($active,$v)?"active":"")."'><a href='#'>$k</a>";
			$html.=arrayToMenu($v,$active);
			$html.="</li>";
		}else{
			$html.="<li><a  class='".($k==$active?"active":"")."' href='$v'>$k</a></li>";
		}
	}
	$html.="</ul>";
	
	return $html;
}

/**
 * 
 * @param string $table Table name
 * @param string array $cols columns to select
 * @param string $key conditional key column
 * @param string $value key value to be compare
 * @param boolean $array true if result has multiple rows else false
 */

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

function alert($msg){
	echo "<script type='text/javascript'>alert('".$msg."');</script>"; 
}
?>
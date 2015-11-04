<?php

function common_view_imports() {
	// W3.CSS
	echo '<link rel="stylesheet" href="view/css/w3.css">';
	echo '<link rel="stylesheet" href="view/css/style.css">';
	echo '<script type="text/javascript" src="view/js/jquery-2.1.4.min.js"></script>';
}

function side_navigation_panel($selected='NULL'){
	$item = array();
	
	$item['Home'] = 'index.php';
	$item['New Notice'] = 'index.php?opt=new_notice';
	$item['home3'] = 'index.php';
	$item['home4'] = 'index.php';
	$item['home5'] = 'index.php';
	$item['home6'] = 'index.php';
	$item['Log Out'] = 'index.php?opt=logout';
	
	?>
	<nav class="w3-sidenav w3-white w3-card-8" style="width:300px">
		<header class="w3-container w3-teal">
			<h5><?php echo $_SESSION['user']?></h5>
		</header>
		<header class="w3-container w3-blue">
			<h5>Menu</h5>
		</header>
		<?php 
		foreach ($item as $k => $v){
			if($selected == $k)
				echo "<a href=".$v." class='w3-dark-grey'>".$k."</a>";
			else 
				echo "<a href=".$v.">".$k."</a>";
		} 
		?>
	</nav>
	<?php 
	
}

/**
 * 
 * @param string $table Table name
 * @param string array $cols columns to select
 * @param string $key conditional key column
 * @param string $value key value to be compare
 * @param boolean $array true if result has multiple rows else false
 */

function fetchData($table,$cols,$key,$value,$array=false){
	global $db_con;
	
	$sql="SELECT `".implode('`,`', $cols)."` from `$table` where `$key` = :value";
	
	$stmt = $db_con->prepare ($sql);
	$stmt->execute ( array (
		'value' => $value
	) );
	
	if($array)
		return $stmt->fetchAll();
	else
		return $stmt->fetch();
}
?>
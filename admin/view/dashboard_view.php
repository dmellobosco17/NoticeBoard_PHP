<?php 
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}
?>
<html>
<head>
<title><?php echo $app_title;?></title>
<?php common_view_imports();?>

</head>
<body>
	<?php side_navigation_panel('Home')?>
	<div style="height: 30px"></div>
	
	<?php 
		$notices = $data['notices'];
		
		foreach ($notices as $note){
			$date=date_create($note['expiry']);
			$expiry=date_format($date,"d/m/Y");
			$date=date_create($note['time']);
			$time=date_format($date,"d/m/Y H:i A");
				
			?>
			<div class="w3-card-8" style="margin: 0px 30px 0px 330px;">
				<div class="w3-container <?php echo $note['priority']==1?'w3-teal':'w3-deep-orange';?>">
					<h2><?php echo $note['subject'];?></h2>
				</div>
				<form class="w3-container">
					<div class="w3-row">
						<div class="w3-group w3-col m3">
							<label class="w3-label"><b>Notice priority</b></label>
							<h5><?php echo $note['priority'] == '1'? 'Normal' : 'Important';?></h5>
						</div>
						<div class="w3-group w3-col m1"></div>
						<div class="w3-group w3-col m3">
							<label class="w3-label"><b>Channel</b></label>
							<h5><?php echo $note['channel_name'];?></h5>
						</div>
						<div class="w3-group w3-col m1"></div>
						<div class="w3-group w3-col m3">
							<label class="w3-label"><b>Expiry Date</b></label>
							<h5><?php echo $expiry;?></h5>
						</div>
						<div class="w3-group w3-col m8">
							<label class="w3-label"><b>Published By</b></label>
							<h5><?php echo $note['user'];?></h5>
						</div>
						<div class="w3-group w3-col m4">
							<label class="w3-label"><b>Added At</b></label>
							<h5><?php echo $time;?></h5>
						</div>
					</div>
		
					<div class="w3-group">
						<h5><?php echo $note['content'];?></h5>
					</div>
		
				</form>
			</div>
			
			<?php 
		}
	
	?>
	</body>
</html>
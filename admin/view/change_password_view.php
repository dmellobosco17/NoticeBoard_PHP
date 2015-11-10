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
	<div class="w3-row">
<?php side_navigation_panel('Change Password')?>
<?php $user = $data['user'];?>
<div style="height: 30px"></div>
		<div class="w3-card-8" style="margin: 0px 30px 0px 330px;">
			<div class="w3-container w3-teal">
				<h2>Change Password</h2>
			</div>
			<form class="w3-container" method="post"
				action="index.php?opt=password&act=do" onsubmit="return validate()">
				<div class="w3-row">
					<div class="w3-group w3-col m5">
						<div class="w3-group">
							<input class="w3-input" name="pass1" id="pass1" type="password">
							<label class="w3-label">Password</label>
						</div>
						<div class="w3-group">
							<input class="w3-input" id="pass2" type="password"> <label
								class="w3-label">Confirm Password</label>
						</div>
					</div>
					<div class="w3-group w3-col m6">
					</div>
				</div>
				<button id="change_pass" class="w3-btn w3-teal w3-margin-bottom">Change Password</button>
			</form>
		</div>
	</div>
	<script type="text/javascript">
	
		function validate(){		
			err="";
			if($("#pass1").val()==''){
				err+="Password cannot be empty.\n";
			}
			if($("#pass2").val()==''){
				err+="Please enter confirm password.\n";
			}
			
			if($("#pass1").val()!=$("#pass2").val()){
				err+="Confirm password does not match\n";
			}
			if(err=="")
				return confirm("Do you want to submit this data?");
			else
				alert(err);

			return false;
		}
	</script>
</body>
</html>
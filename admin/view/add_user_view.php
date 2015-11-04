<html>
<head>
<title><?php echo $app_title;?></title>
<?php common_view_imports();?>
</head>
<body>
	<div class="w3-row">
<?php side_navigation_panel('Manage Users')?>
<div style="height: 30px"></div>
		<div class="w3-card-8" style="margin: 0px 30px 0px 330px;">
			<div class="w3-container w3-teal">
				<h2>Add New User</h2>
			</div>
			<form class="w3-container" method="post" action="index.php?opt=add_user&act=do" onsubmit="return validate()">
				<div class="w3-row">
					<div class="w3-group w3-col m3">
						<label class="w3-label"><b>User Type</b></label> 
						<select name="type" id="type" class="w3-select w3-section">
							<option value="PUBLISHER">Publisher</option>
							<option value="ADMIN">Admin</option>
						</select>
					</div>
					<div class="w3-group w3-col m1"></div>
					<div class="w3-group w3-col m3">
						<label class="w3-label"><b>Channel</b></label> 
						<select name="channel" id="channel" class="w3-select w3-section">
						<?php 
							$channels = $data['channels'];
							foreach($channels as $ch){
								echo "<option value='$ch[id]'>$ch[name]</option>";
							}
						?>
						</select>
					</div>
					<div class="w3-group w3-col m1"></div>
					
				</div>
				<div class="w3-group">
					<input class="w3-input" name="username" id="username" type="text"> <label class="w3-label">User Name</label>
				</div>
				<div class="w3-group">
					<input class="w3-input" name="pass1" id="pass1" type="password"> <label class="w3-label">Password</label>
				</div>
				<div class="w3-group">
					<input class="w3-input" id="pass2" type="password"> <label class="w3-label">Confirm Password</label>
				</div>
				
					<button id="add_user" class="w3-btn w3-teal w3-margin-bottom">Add New User</button>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		function validate(){
			err="";
			if($("#username").val()==''){
				err+="Please enter username\n";
			}
			if($("#pass1").val()==''){
				err+="Please enter password\n";
			}
			if($("#pass2").val()==''){
				err+="Please enter confirm password\n";
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
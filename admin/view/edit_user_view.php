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
<?php side_navigation_panel('Manage Users')?>
<?php $user = $data['user'];?>
<div style="height: 30px"></div>
		<div class="w3-card-8" style="margin: 0px 30px 0px 330px;">
			<div class="w3-container w3-teal">
				<h2>Edit User : <?php echo $user['username']?></h2>
			</div>
			<form class="w3-container" method="post"
				action="index.php?opt=edit_user&act=do" onsubmit="return validate()">
				<input type="hidden" name="id" value="<?php echo $user['id'];?>">
				<div class="w3-row">
					<div class="w3-group w3-col m5">
						<div class="w3-group">
							<input class="w3-input" name="username" id="username" type="text" value="<?php echo $user['username'];?>">
							<label class="w3-label">User Name</label>
						</div>
						<div class="w3-group">
							<input class="w3-input" name="pass1" id="pass1" type="password">
							<label class="w3-label">Password</label>
						</div>
						<div class="w3-group">
							<input class="w3-input" id="pass2" type="password"> <label
								class="w3-label">Confirm Password</label>
						</div>
					</div>
					<div class="w3-group w3-col m1">
						<p id="err" style="background-color: pink;">Username not availabe, Please choose different name.</p>
					</div>
					<div class="w3-group w3-col m6">
					<div class="w3-group">
						<label class="w3-label"><b>User Type</b></label> 
						<select	name="type" id="type" class="w3-select w3-section">
							<option value="PUBLISHER" <?php echo $user['type'] == 'PUBLISHER'? 'selected':'';?>>Publisher</option>
							<option value="ADMIN" <?php echo $user['type'] == 'ADMIN'? 'selected':'';?>>Admin</option>
						</select>
						</div>
						<div class="w3-group">
						 <label class="w3-label"><b>Channel</b></label>
						 <select multiple="true" name="channel[]" id="channel" class="w3-select w3-section">
						<?php
						$channels = $data ['channels'];
						foreach ( $channels as $ch ) {
							echo "<option value='$ch[id]'".(strpos($user['channel'],$ch['id']) !== false?'selected':'').">$ch[name]</option>";
						}
						?>
						</select>
					</div>
					</div>
				</div>
				<button id="edit_user" class="w3-btn w3-teal w3-margin-bottom">Edit User</button>
			</form>
		</div>
	</div>
	<script type="text/javascript">
	$("#err").hide();
	$("#username").keyup(function(){
		$.ajax({
            url: 'index.php?opt=live_feed',
            dataType: 'text',
            type: 'post',
            data: 'seed='+$("#username").val()+'&match=exact&procedure_code=new_user_name',
            success: function( data, textStatus, jQxhr ){
                if(data != '[]')
                    $("#err").show();
                else
                	$("#err").hide();
            },
            error: function( jqXhr, textStatus, errorThrown ){
                $("#output").html( errorThrown );
            }
        });
	});
	
		function validate(){
			var channels = JSON.stringify($("#channel").val());
			
			err="";
			if($("#username").val()==''){
				err+="Please enter username\n";
			}
			if($("#pass1").val()!='' && $("#pass2").val()==''){
				err+="Please enter confirm password\n";
			}
			if(channels =='null'){
				err+="Please select atlease one channel.\n";
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
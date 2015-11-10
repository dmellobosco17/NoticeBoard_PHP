<?php 
if (! defined ( 'INDEX' )) {
	die("Attempt to hack !!!");
}
?>
<html>
<head>
<title><?php echo $app_title;?></title>
<?php common_view_imports();?>

<style type="text/css">
#form {
	margin: 115px auto;
	width: 570px;
}
</style>
</head>
<body>
	<div id="form" class="w3-container">
		<header class="w3-blue" style="padding-left: 15px;">
			<h1>Login</h1>
		</header>
		<form class="w3-form w3-card-24">

			<div class="w3-group">
				<label>User Name</label> <input id="username" class="w3-input"
					type="text">
			</div>
			<div class="w3-group">
				<label>Password</label> <input id="password" class="w3-input"
					type="password">
			</div>
			<input type="button" id="login-btn" class="w3-btn w3-teal"
				value="Login" />
		</form>
	</div>

	<script type="text/javascript">
$(document).ready(function(){
	$("#login-btn").click(function(){
		if($("#username").val() == "" || $("#password").val() == ""){
			alert("Please enter username and password !!!");
			return;
		}
		
		$.ajax({
            url: 'index.php?opt=authenticate',
            dataType: 'text',
            type: 'post',
            data: 'username='+$("#username").val()+'&password='+$('#password').val(),
            success: function( data, textStatus, jQxhr ){
				if(data=="success"){
					window.location.assign("index.php");
				}
				else{
					alert(data);
				}
            },
            error: function( jqXhr, textStatus, errorThrown ){
                alert(errorThrown);
            }
        });
	});
});
</script>
</body>
</html>
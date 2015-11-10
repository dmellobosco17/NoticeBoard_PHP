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
<?php side_navigation_panel('Manage Channels')?>
<div style="height: 30px"></div>
		<div class="w3-card-8" style="margin: 0px 30px 0px 330px;">
			<div class="w3-container w3-teal">
				<h2>Add New Channel</h2>
			</div>
			<form class="w3-container" method="post"
				action="index.php?opt=add_channel&act=do" onsubmit="return validate()">
				<div class="w3-row">
					<div class="w3-group w3-col m5">
						<div class="w3-group">
							<input class="w3-input" name="name" id="name" type="text">
							<label class="w3-label">Channel Name</label>
						</div>
						<div class="w3-group">
							<input class="w3-input" name="desc" id="desc" type="text">
							<label class="w3-label">Description</label>
						</div>
					</div>
					<div class="w3-group w3-col m1">
						<p id="err" style="background-color: pink;">Channel name not availabe, Please choose different name.</p>
					</div>
					<div class="w3-group w3-col m6">
					</div>
				</div>
				<button id="add_channel" class="w3-btn w3-teal w3-margin-bottom">Add New Channel</button>
			</form>
		</div>
	</div>
	<script type="text/javascript">
	$("#err").hide();
		$("#name").keyup(function(){
			$.ajax({
                url: 'index.php?opt=live_feed',
                dataType: 'text',
                type: 'post',
                data: 'seed='+$("#name").val()+'&match=exact&procedure_code=new_channel_name',
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
			if($("#rname").val()==''){
				err+="Please enter channel name\n";
			}
			if($("#desc1").val()==''){
				err+="Please enter password\n";
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